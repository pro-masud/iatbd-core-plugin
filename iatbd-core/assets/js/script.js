document.getElementById("theme-toggle").addEventListener("click", () => {
  document.documentElement.classList.toggle("dark");
  localStorage.setItem(
    "iatbd-theme",
    document.documentElement.classList.contains("dark") ? "dark" : "light",
  );
});
const mbtn = document.getElementById("mobile-menu-btn");
const mmenu = document.getElementById("mobile-menu");
mbtn.addEventListener("click", () => {
  mmenu.classList.toggle("hidden");
  mbtn.querySelector("i").classList.toggle("fa-bars");
  mbtn.querySelector("i").classList.toggle("fa-times");
});
document.querySelectorAll('a[href^="#"]').forEach((a) => {
  a.addEventListener("click", (e) => {
    const t = document.querySelector(a.getAttribute("href"));
    if (t) {
      e.preventDefault();
      t.scrollIntoView({ behavior: "smooth" });
      mmenu.classList.add("hidden");
    }
  });
});
document.querySelectorAll(".faq-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    const item = btn.closest(".faq-item");
    const open = item.classList.contains("open");
    document
      .querySelectorAll(".faq-item")
      .forEach((i) => i.classList.remove("open"));
    if (!open) item.classList.add("open");
  });
});

// Hero slider
(function () {
  const slides = document.querySelectorAll(".servo-slide");
  const dots = document.querySelectorAll(".servo-dot");
  let cur = 0,
    t;
  function show(i) {
    cur = (i + slides.length) % slides.length;
    slides.forEach((s, n) => s.classList.toggle("active", n === cur));
    dots.forEach((d, n) => d.classList.toggle("active", n === cur));
  }
  function start() {
    clearInterval(t);
    t = setInterval(() => show(cur + 1), 5000);
  }
  dots.forEach((d) =>
    d.addEventListener("click", () => {
      show(+d.dataset.i);
      start();
    }),
  );
  const hero = document.querySelector(".servo-hero");
  if (hero) {
    hero.addEventListener("mouseenter", () => clearInterval(t));
    hero.addEventListener("mouseleave", start);
  }
  show(0);
  start();
})();

// Countdown animation
(function () {
  const counters = document.querySelectorAll(".counter");
  let started = false;
  function animate() {
    if (started) return;
    started = true;
    counters.forEach((el) => {
      const target = +el.dataset.target;
      const suffix = el.dataset.suffix || "";
      const duration = 1600;
      const startTime = performance.now();
      function tick(now) {
        const p = Math.min((now - startTime) / duration, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.floor(eased * target) + suffix;
        if (p < 1) requestAnimationFrame(tick);
        else el.textContent = target + suffix;
      }
      requestAnimationFrame(tick);
    });
  }
  const observer = new IntersectionObserver(
    (entries) => {
      if (entries.some((e) => e.isIntersecting)) {
        animate();
        observer.disconnect();
      }
    },
    { threshold: 0.3 },
  );
  const first = document.querySelector(".count-box");
  if (first) observer.observe(first);
})();

// Testimonials
(function () {
  const track = document.getElementById("testimonial-track");
  const dotsWrap = document.getElementById("testimonial-dots");
  if (!track) return;
  const total = track.querySelectorAll(".testimonial-card").length;
  let idx = 0,
    timer;
  const pv = () => (window.innerWidth >= 768 ? 3 : 1);
  const max = () => Math.max(0, total - pv());
  function dots() {
    dotsWrap.innerHTML = "";
    for (let i = 0; i <= max(); i++) {
      const b = document.createElement("button");
      b.className =
        "h-2 rounded-full transition-all " +
        (i === idx
          ? "w-6 bg-primary-500"
          : "w-2 bg-slate-300 dark:bg-slate-600");
      b.onclick = () => {
        idx = i;
        go();
        start();
      };
      dotsWrap.appendChild(b);
    }
  }
  function go() {
    if (idx > max()) idx = 0;
    track.style.transform = "translateX(-" + (100 / pv()) * idx + "%)";
    dots();
  }
  function start() {
    clearInterval(timer);
    timer = setInterval(() => {
      idx = idx >= max() ? 0 : idx + 1;
      go();
    }, 2000);
  }
  window.addEventListener("resize", go);
  go();
  start();
  const vp = document.getElementById("testimonial-viewport");
  if (vp) {
    vp.addEventListener("mouseenter", () => clearInterval(timer));
    vp.addEventListener("mouseleave", start);
  }
})();
