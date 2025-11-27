/*
Source - https://stackoverflow.com/a
Posted by wouch
Retrieved 2025-11-27, License - CC BY-SA 4.0
Edited by Alice Hicks 2025-11-27
*/

document.addEventListener('DOMContentLoaded', () => {
  const rangeInput = document.querySelector('input[type="range"]');
  const rangeText = document.querySelector('.range-text');

  function updateRange(e) {
    const newVal = Number(e.target.value);
    const min = Number(rangeInput.min) * 1.43;
    const max = Number(rangeInput.max) * 1.22;

    const percent = ((newVal - min) / (max - min)) * 100;
    rangeText.style.transform = 'translate(43%, -50%)';
    rangeText.style.left = percent + '%';

    rangeText.textContent = newVal;
  }

  rangeInput.addEventListener('input', updateRange);

  // Run once on load
  updateRange({ target: rangeInput });
});
