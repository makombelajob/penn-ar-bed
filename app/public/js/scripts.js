document.addEventListener('mousemove', (e) => {
    const hero = document.querySelector('.home-hero');
    if (!hero) return;
    const rect = hero.getBoundingClientRect();
    const relX = (e.clientX - rect.left) / rect.width - 0.5;
    const relY = (e.clientY - rect.top) / rect.height - 0.5;

    hero.style.setProperty('--parallax-x', (relX * 8).toFixed(2) + 'px');
    hero.style.setProperty('--parallax-y', (relY * 8).toFixed(2) + 'px');
});

// Subtle parallax on the visual block
document.addEventListener('mousemove', (e) => {
    const visual = document.querySelector('.home-hero-visual');
    if (!visual) return;
    const rect = visual.getBoundingClientRect();
    const relX = (e.clientX - rect.left) / rect.width - 0.5;
    const relY = (e.clientY - rect.top) / rect.height - 0.5;
    visual.style.transform = `translate3d(${relX * 8}px, ${relY * 8}px, 0)`;
});
