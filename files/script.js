// script.js
// 已配置为 10 层：第一层使用 assets/floors/1.png（你提供的 1.png）
// 其他层使用 assets/floors/2.png 作为占位图（共 9 层占位）
// 请把图片放到仓库：assets/floors/1.png 与 assets/floors/2.png
// 或将 URL 替换为你自己的外链路径

const floors = [
  {
    id: "floor-1",
    title: "一楼 · 院子",
    type: "courtyard",
    height: "65vh",
    bgImage: "assets/floors/1.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-2",
    title: "二楼",
    type: "floor",
    height: "480px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-3",
    title: "三楼",
    type: "floor",
    height: "560px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-4",
    title: "四楼",
    type: "floor",
    height: "55vh",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-5",
    title: "五楼",
    type: "floor",
    height: "620px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-6",
    title: "六楼",
    type: "floor",
    height: "500px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-7",
    title: "七楼",
    type: "floor",
    height: "auto",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-8",
    title: "八楼",
    type: "floor",
    height: "540px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-9",
    title: "九楼",
    type: "floor",
    height: "480px",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  },
  {
    id: "floor-10",
    title: "十楼",
    type: "floor",
    height: "55vh",
    bgImage: "assets/floors/2.png",
    placeholder: "assets/floors/2.png"
  }
];

// ---------- 其余逻辑与之前模板一致 ----------

// DOM references
const building = document.getElementById("building");
const entrance = document.getElementById("entrance");
const enterBtn = document.getElementById("enterBtn");

// 创建单层 DOM
function createFloorNode(f) {
  const node = document.createElement("section");
  node.className = "floor";
  if (f.type === "courtyard") node.classList.add("courtyard");
  node.id = f.id;

  // 设置高度
  if (f.height && f.height !== "auto") {
    node.style.minHeight = f.height;
    node.style.height = f.height;
  } else {
    node.style.height = "auto";
  }

  // 背景层（懒加载背景图）
  const bg = document.createElement("div");
  bg.className = "floor-bg";
  if (f.bgImage) bg.dataset.bg = f.bgImage;
  if (f.placeholder) bg.style.backgroundImage = `url('${f.placeholder}')`;

  // 内容层
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
  list.forEach(f => {
    const node = createFloorNode(f);
    fragment.appendChild(node);
  });
  building.appendChild(fragment);
}

// 懒加载逻辑
const observerOptions = {
  root: null,
  rootMargin: "300px 0px 300px 0px",
  threshold: 0.01
};

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
  const floorEls = building.querySelectorAll(".floor");
  floorEls.forEach(el => {
    lazyObserver.observe(el);
  });
}

enterBtn.addEventListener("click", () => {
  entrance.style.display = "none";
  requestAnimationFrame(() => {
    const first = document.querySelector(".floor");
    if (first) first.scrollIntoView({ behavior: "smooth", block: "start" });
  });
});

window.addEventListener("keydown", (e) => {
  if (["ArrowDown","ArrowUp","PageDown","PageUp"].includes(e.key)) {
    e.preventDefault();
    navigateByKey(e.key);
  }
});

function navigateByKey(key) {
  const floorsEls = Array.from(document.querySelectorAll(".floor"));
  if (!floorsEls.length) return;
  const viewportTop = window.scrollY;
  let index = floorsEls.findIndex(el => el.getBoundingClientRect().top + window.scrollY >= viewportTop + 10);
  if (index === -1) index = floorsEls.length - 1;

  if (key === "ArrowDown" || key === "PageDown") {
    const next = floorsEls[Math.min(index + 1, floorsEls.length - 1)];
    next && next.scrollIntoView({ behavior: "smooth", block: "start" });
  } else {
    const prev = floorsEls[Math.max(index - 1, 0)];
    prev && prev.scrollIntoView({ behavior: "smooth", block: "start" });
  }
}

window.setFloors = function(newFloors) {
  if (!Array.isArray(newFloors)) {
    console.error("setFloors 参数需为数组");
    return;
  }
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