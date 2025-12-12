// script.js — 已调整：默认由 CSS 按图片比例计算高度（width * 880/1184）
// 若需要单层自定义高度，请把该层的 height 字段设为具体值（如 "480px" 或 "60vh"）

const floors = [
  { id: "floor-1", title: "", type: "courtyard", height: "auto", bgImage: "assets/floors/1.png", placeholder: "assets/floors/2.png" },
  { id: "floor-2", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-3", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-4", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-5", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-6", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-7", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-8", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-9", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-10", title: "", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" }
];

// DOM refs
const building = document.getElementById("building");
const entrance = document.getElementById("entrance");
const enterBtn = document.getElementById("enterBtn");

function createFloorNode(f) {
  const node = document.createElement("section");
  node.className = "floor";
  if (f.type === "courtyard") node.classList.add("courtyard");
  node.id = f.id;

  // 如果用户明确设置了非 "auto" 高度（如 "480px" 或 "55vh"），优先使用它覆盖 CSS 默认
  if (f.height && f.height !== "auto") {
    node.style.minHeight = f.height;
    node.style.height = f.height;
  } else {
    // 由 CSS 的 aspect-ratio / calc 控制高度：不写入 inline height
    node.style.height = "auto";
  }

  const bg = document.createElement("div");
  bg.className = "floor-bg";
  if (f.bgImage) bg.dataset.bg = f.bgImage;
  if (f.placeholder) bg.style.backgroundImage = `url('${f.placeholder}')`;

  const content = document.createElement("div");
  content.className = "floor-content";
  content.innerHTML = `<h2>${escapeHtml(f.title || "")}</h2>`;

  node.appendChild(bg);
  node.appendChild(content);
  return node;
}

function escapeHtml(str) {
  return (str || "").replace(/[&<>"']/g, function(m) {
    return ({
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;"
    })[m];
  });
}

function renderFloors(list) {
  building.innerHTML = "";
  const fragment = document.createDocumentFragment();
  list.forEach(f => fragment.appendChild(createFloorNode(f)));
  building.appendChild(fragment);
}

const observerOptions = { root: null, rootMargin: "300px 0px 300px 0px", threshold: 0.01 };
const lazyObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const floorEl = entry.target;
    const bgEl = floorEl.querySelector(".floor-bg");
    if (!bgEl) return;
    const imgUrl = bgEl.dataset.bg;
    if (imgUrl) {
      const img = new Image();
      img.src = imgUrl;
      img.onload = () => {
        bgEl.style.backgroundImage = `url('${imgUrl}')`;
        floorEl.classList.add("loaded");
      };
      img.onerror = () => {
        floorEl.classList.add("loaded");
        console.warn("图片加载失败：", imgUrl);
      };
      delete bgEl.dataset.bg;
    } else {
      floorEl.classList.add("loaded");
    }
    lazyObserver.unobserve(floorEl);
  });
}, observerOptions);

function observeFloors() {
  document.querySelectorAll(".floor").forEach(el => lazyObserver.observe(el));
}

enterBtn.addEventListener("click", () => {
  entrance.style.display = "none";
  requestAnimationFrame(() => {
    const first = document.querySelector(".floor");
    if (first) first.scrollIntoView({ behavior: "smooth", block: "end" });
  });
});

window.addEventListener("keydown", (e) => {
  if (["ArrowDown","ArrowUp","PageDown","PageUp"].includes(e.key)) {
    e.preventDefault();
    navigateByKey(e.key);
  }
});

function getCurrentFloorIndex() {
  const floorsEls = Array.from(document.querySelectorAll(".floor"));
  if (!floorsEls.length) return -1;
  const viewportCenter = window.innerHeight / 2;
  let index = floorsEls.findIndex(el => el.getBoundingClientRect().bottom >= viewportCenter);
  if (index === -1) index = floorsEls.length - 1;
  return index;
}

function navigateByKey(key) {
  const floorsEls = Array.from(document.querySelectorAll(".floor"));
  if (!floorsEls.length) return;
  let index = getCurrentFloorIndex();
  if (index === -1) index = 0;

  if (key === "ArrowUp" || key === "PageUp") {
    const next = floorsEls[Math.min(index + 1, floorsEls.length - 1)];
    next && next.scrollIntoView({ behavior: "smooth", block: "end" });
  } else {
    const prev = floorsEls[Math.max(index - 1, 0)];
    prev && prev.scrollIntoView({ behavior: "smooth", block: "end" });
  }
}

window.setFloors = function(newFloors) {
  if (!Array.isArray(newFloors)) { console.error("setFloors 参数需为数组"); return; }
  window._userFloors = newFloors;
};

window.initBuilding = function() {
  const list = window._userFloors || floors;
  renderFloors(list);
  observeFloors();
};

document.addEventListener("DOMContentLoaded", () => {
  window._userFloors = floors;
  initBuilding();
});