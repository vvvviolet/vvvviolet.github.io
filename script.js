// script.js（调整：移除“查看插画”按钮，整层点击即可打开画廊；标题改为不阻挡的角标）
//
// 画廊图片位置约定： assets/floors/{floorId}/gallery.json（推荐）
// 回退： assets/floors/{floorId}/image-1.png ... image-N.png

const floors = [
  { id: "floor-1", title: "一楼 · 院子", type: "courtyard", height: "auto", bgImage: "assets/floors/1.png", placeholder: "assets/floors/2.png" },
  { id: "floor-2", title: "二楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-3", title: "三楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-4", title: "四楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-5", title: "五楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-6", title: "六楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-7", title: "七楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-8", title: "八楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-9", title: "九楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" },
  { id: "floor-10", title: "十楼", type: "floor", height: "auto", bgImage: "assets/floors/2.png", placeholder: "assets/floors/2.png" }
];

// DOM refs
const building = document.getElementById("building");
const entrance = document.getElementById("entrance");
const enterBtn = document.getElementById("enterBtn");

// Gallery DOM
const galleryModal = document.getElementById("galleryModal");
const galleryTitle = document.getElementById("galleryTitle");
const galleryLarge = document.getElementById("galleryLarge");
const galleryGrid = document.getElementById("galleryGrid");
const galleryInfo = document.getElementById("galleryInfo");
const galleryClose = document.getElementById("galleryClose");

// 创建单层 DOM（标题为角标，整层点击打开画廊）
function createFloorNode(f) {
  const node = document.createElement("section");
  node.className = "floor";
  if (f.type === "courtyard") node.classList.add("courtyard");
  node.id = f.id;

  // 优先使用显式高度（非 "auto"）
  if (f.height && f.height !== "auto") {
    node.style.minHeight = f.height;
    node.style.height = f.height;
  } else {
    node.style.height = "auto";
  }

  const bg = document.createElement("div");
  bg.className = "floor-bg";
  if (f.bgImage) bg.dataset.bg = f.bgImage;
  if (f.placeholder) bg.style.backgroundImage = `url('${f.placeholder}')`;

  // 标题作为角标（pointer-events: none，以免阻挡整层点击）
  const content = document.createElement("div");
  content.className = "floor-content";
  content.innerHTML = `<h2 class="floor-title">${escapeHtml(f.title || "")}</h2>`;

  node.appendChild(bg);
  node.appendChild(content);

  // 整层点击打开画廊（不需要按钮）
  node.addEventListener("click", (ev) => {
    openGallery(f.id, f.title);
  });

  return node;
}

function escapeHtml(str) {
  return (str || "").replace(/[&<>"']/g, function(m) {
    return ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" })[m];
  });
}

// 渲染
function renderFloors(list) {
  building.innerHTML = "";
  const fragment = document.createDocumentFragment();
  list.forEach(f => fragment.appendChild(createFloorNode(f)));
  building.appendChild(fragment);
}

// 懒加载背景图（与之前逻辑一致）
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
      img.onload = () => { bgEl.style.backgroundImage = `url('${imgUrl}')`; floorEl.classList.add("loaded"); };
      img.onerror = () => { floorEl.classList.add("loaded"); console.warn("图片加载失败：", imgUrl); };
      delete bgEl.dataset.bg;
    } else {
      floorEl.classList.add("loaded");
    }
    lazyObserver.unobserve(floorEl);
  });
}, observerOptions);

function observeFloors() { document.querySelectorAll(".floor").forEach(el => lazyObserver.observe(el)); }

// ---------- 画廊逻辑（同前） ----------
async function openGallery(floorId, title) {
  galleryTitle.textContent = title || "画廊";
  galleryGrid.innerHTML = "";
  galleryLarge.src = "";
  galleryInfo.textContent = "加载中…";
  showGalleryModal(true);

  const basePath = `assets/floors/${floorId}/`;
  const manifestPath = `${basePath}gallery.json`;

  let images = [];

  try {
    const res = await fetch(manifestPath, { cache: "no-cache" });
    if (res.ok) {
      const list = await res.json();
      if (Array.isArray(list) && list.length) {
        images = list.map(fn => (fn.startsWith("http") ? fn : (basePath + fn)));
      }
    }
  } catch (e) {
    console.warn("读取 gallery.json 失败或不存在：", e);
  }

  if (!images.length) {
    images = await detectNumberedImages(basePath, 20, ["png","jpg","jpeg","webp"]);
  }

  if (!images.length) {
    galleryInfo.textContent = "未找到插画（请把图片放在 " + basePath + " 或创建 gallery.json）";
    return;
  }

  galleryInfo.textContent = `${images.length} 张插画`;
  images.forEach((url, idx) => {
    const a = document.createElement("a");
    a.href = url;
    a.className = "thumb";
    a.dataset.index = String(idx);
    a.addEventListener("click", (ev) => {
      ev.preventDefault();
      showLargeImage(url, idx, images);
    });

    const img = document.createElement("img");
    img.alt = `${title || "插画"} · ${idx + 1}`;
    img.loading = "lazy";
    img.src = url;
    a.appendChild(img);
    galleryGrid.appendChild(a);
  });

  showLargeImage(images[0], 0, images);
}

function showLargeImage(url, idx, list) {
  galleryLarge.src = url;
  galleryLarge.alt = `第 ${idx + 1} 张`;
  galleryLarge.dataset.index = String(idx);
  galleryInfo.textContent = `${idx + 1} / ${list.length}`;
}

function detectNumberedImages(basePath, maxCount = 20, exts = ["png","jpg","jpeg","webp"]) {
  const checks = [];
  for (let i = 1; i <= maxCount; i++) {
    for (const ext of exts) {
      const url = `${basePath}image-${i}.${ext}`;
      checks.push(checkImageExists(url).then(ok => ok ? url : null));
    }
  }
  return Promise.all(checks).then(results => results.filter(Boolean));
}

function checkImageExists(url) {
  return new Promise((resolve) => {
    const img = new Image();
    let done = false;
    const onOk = () => { if (!done) { done = true; clearTimeout(t); resolve(true); } };
    const onErr = () => { if (!done) { done = true; clearTimeout(t); resolve(false); } };
    img.onload = onOk;
    img.onerror = onErr;
    const t = setTimeout(() => { if (!done) { done = true; img.src = ""; resolve(false); } }, 4000);
    img.src = url;
  });
}

function showGalleryModal(open) {
  if (open) {
    galleryModal.classList.add("open");
    galleryModal.setAttribute("aria-hidden", "false");
    document.body.classList.add("modal-open");
  } else {
    galleryModal.classList.remove("open");
    galleryModal.setAttribute("aria-hidden", "true");
    document.body.classList.remove("modal-open");
  }
}
galleryClose.addEventListener("click", () => showGalleryModal(false));
galleryModal.querySelector('[data-action="close"]').addEventListener("click", () => showGalleryModal(false));
window.addEventListener("keydown", (e) => { if (e.key === "Escape" && galleryModal.classList.contains("open")) showGalleryModal(false); });

// ---------- 初始化与键盘导航 ----------
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

// 渲染/观察
function renderFloors(list) {
  building.innerHTML = "";
  const fragment = document.createDocumentFragment();
  list.forEach(f => fragment.appendChild(createFloorNode(f)));
  building.appendChild(fragment);
}
const observerOptions2 = { root: null, rootMargin: "300px 0px 300px 0px", threshold: 0.01 };
const lazyObserver2 = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const floorEl = entry.target;
    const bgEl = floorEl.querySelector(".floor-bg");
    if (!bgEl) return;
    const imgUrl = bgEl.dataset.bg;
    if (imgUrl) {
      const img = new Image();
      img.src = imgUrl;
      img.onload = () => { bgEl.style.backgroundImage = `url('${imgUrl}')`; floorEl.classList.add("loaded"); };
      img.onerror = () => { floorEl.classList.add("loaded"); console.warn("图片加载失败：", imgUrl); };
      delete bgEl.dataset.bg;
    } else {
      floorEl.classList.add("loaded");
    }
    lazyObserver2.unobserve(floorEl);
  });
}, observerOptions2);

function observeFloors2() { document.querySelectorAll(".floor").forEach(el => lazyObserver2.observe(el)); }

window.setFloors = function(newFloors) {
  if (!Array.isArray(newFloors)) { console.error("setFloors 参数需为数组"); return; }
  window._userFloors = newFloors;
};

window.initBuilding = function() {
  const list = window._userFloors || floors;
  renderFloors(list);
  observeFloors2();
};

document.addEventListener("DOMContentLoaded", () => {
  window._userFloors = floors;
  initBuilding();
});