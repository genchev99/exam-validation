const control = document.importNode(document.querySelector('template').content, true).childNodes[0];
control.addEventListener('pointerdown', oncontroldown, true);

document.querySelector('p').onpointerup = () => {
  const selection = document.getSelection()
  const text = selection.toString()

  if (text === "") {
    return;
  }

  const rect = selection.getRangeAt(0).getBoundingClientRect();

  control.style.top = `calc(${rect.top}px - 48px)`;
  control.style.left = `calc(${rect.left}px + calc(${rect.width}px / 2) - 40px)`;
  control['text'] = text;

  document.body.appendChild(control);
}

function oncontroldown(event) {
  console.log(event);

  // window.open(`https://twitter.com/intent/tweet?text=${this.text}`);
  this.remove();
  document.getSelection().removeAllRanges();
  event.stopPropagation();
}

document.onpointerdown = () => {
  const control = document.querySelector('#control');

  if (!control) {
    return;
  }

  control.remove();
  document.getSelection().removeAllRanges();
}
