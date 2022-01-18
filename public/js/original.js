var control = document.importNode(document.querySelector('template').content, true).childNodes[0];
control.addEventListener('pointerdown', oncontroldown, true);

document.querySelector('p').onpointerup = () => {
  let selection = document.getSelection(), text = selection.toString();
  if (text !== "") {
    let rect = selection.getRangeAt(0).getBoundingClientRect();
    control.style.top = `calc(${rect.top}px - 48px)`;
    control.style.left = `calc(${rect.left}px + calc(${rect.width}px / 2) - 40px)`;
    control['text'] = text;
    document.body.appendChild(control);
  }
}

function oncontroldown(event) {
  window.open(`https://twitter.com/intent/tweet?text=${this.text}`);
  this.remove();
  document.getSelection().removeAllRanges();

  event.stopPropagation()
}

document.onpointerdown = () => {
  let control = document.querySelector('#control');
  if (control !== null) {
    control.remove();
    document.getSelection().removeAllRanges();
  }
}
