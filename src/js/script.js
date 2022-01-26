window.addEventListener('DOMContentLoaded', init, false)

let selectedFiles = []

function init() {
  document.querySelector('#import-box #drop input').addEventListener('change', handleFileSelection, false)
}

function createSpan(textVal) {
  const padSize = 30
  const span = document.createElement('span')
  if (textVal.length > padSize) {
    textVal = `${textVal.slice(0, padSize)}...`
  }
  span.textContent = textVal

  return span
}

function createdFileSelectionInfo(file) {
  const li = document.createElement('li')
  li.classList.add('margin-bot-xsmall')

  const span = createSpan(file.name)
  span.classList.add('file-name')

  const removeButton = document.createElement('button')
  removeButton.textContent = 'remove'
  removeButton.classList.add('control', 'remove', 'error', 'quarter-width')

  removeButton.addEventListener("click", () => {
    selectedFiles.filter(f => f.name !== file.name)
  })

  li.append(span, removeButton)
  return li
}

function handleFileSelection(event) {
  selectedFiles = event.target.files
  if (!selectedFiles) {
    return
  }


  for (const selectedFile of selectedFiles) {
    const li = createdFileSelectionInfo(selectedFile)
    document.querySelector('ul.selected-files').append(li)
  }
}

function handleSelectionRemove() {
  throw new Error("NotImplemented")
}
