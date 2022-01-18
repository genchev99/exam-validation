// https://css-tricks.com/how-to-create-actions-for-selected-text-with-the-selection-api/
let control = null

window.addEventListener('DOMContentLoaded', (event) => {
  console.log('DOM fully loaded and parsed')

  control = document.importNode(document.querySelector('div.template'), true)
  console.log(control.childNodes)

  control.style.display = 'block'


  for (const button of control.querySelectorAll('button')) {
    button.addEventListener('onpointerdown', on_control_down, true)
  }

  for (const el of document.querySelectorAll('p.editable')) {
    el.onpointerup = on_selection
  }

  document.onpointerdown = on_pointer_down
})

function on_control_down(event) {
  console.log('on control down')
  this.remove();
  document.getSelection().removeAllRanges();
  event.stopPropagation()
}

function on_pointer_down() {
  console.log('pointer')

  if (!control) {
    return
  }

  control.remove();
  document.getSelection().removeAllRanges();
}

function on_selection() {
  const selection = document.getSelection()
  const selectedText = selection.toString()

  if (!selectedText) {
    return
  }

  const {top, left, width} = selection.getRangeAt(0).getBoundingClientRect();

  control.style.top = `calc(${top}px - 48px)`;
  control.style.left = `calc(${left}px + calc(${width}px / 2) - 40px)`;
  control['selectedText'] = selectedText;

  document.body.appendChild(control);
}
