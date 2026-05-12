    // alert-sound.js
function playAlert({ frequency = 1000, duration = 200, type = 'square', volume = 0.6, repeat = 3 } = {}) {
  let count = 0;
  const interval = setInterval(() => {
    const ctx  = new (window.AudioContext || window.webkitAudioContext)();
    const osc  = ctx.createOscillator();
    const gain = ctx.createGain();

    osc.connect(gain);
    gain.connect(ctx.destination);

    osc.type            = type;
    osc.frequency.value = frequency;
    gain.gain.setValueAtTime(volume, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration / 1000);

    osc.start(ctx.currentTime);
    osc.stop(ctx.currentTime + duration / 1000);

    if (++count >= repeat) clearInterval(interval);
  }, duration + 150);
}