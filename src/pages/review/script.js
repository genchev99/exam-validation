// // // https://css-tricks.com/how-to-create-actions-for-selected-text-with-the-selection-api/
// // let control = null

// // window.addEventListener('DOMContentLoaded', (event) => {
// //   console.log('DOM fully loaded and parsed')

// //   control = document.importNode(document.querySelector('div.template'), true)
// //   console.log(control.childNodes)

// //   control.style.display = 'block'


// //   for (const button of control.querySelectorAll('button')) {
// //     console.log(button)
// //     button.addEventListener('onpointerdown', on_control_down, true)

// //   }

// //   for (const el of document.querySelectorAll('p.editable')) {
// //     el.onpointerup = on_selection
// //   }

// //   document.onpointerdown = on_pointer_down
// // })

// // function on_control_down(event) {
// //   console.log('on control down')
// //   this.remove();
// //   document.getSelection().removeAllRanges();
// //   event.stopPropagation()
// // }

// // function on_pointer_down() {
//   // const start = document.getSelection().anchorOffset
//   // const end = document.getSelection().focusOffset
// //   document.getElementById("editable").innerHTML = replaceBetween(document.getElementById("editable").innerHTML, start, end, 
// //   strikeThrough(document.getElementById("editable").innerHTML.substring(start, end)))

// //   console.log(`start ${start} end: ${end}`)
// //   console.log('pointers')

// //   if (!control) {
// //     return
// //   }

// //   control.remove();
// //   document.getSelection().removeAllRanges();
// // }

// // function on_selection() {
// //   const selection = document.getSelection()
// //   const selectedText = selection.toString()

// //   if (!selectedText) {
// //     return
// //   }

// //   const {top, left, width} = selection.getRangeAt(0).getBoundingClientRect();

// //   control.style.top = `calc(${top}px - 48px)`;
// //   control.style.left = `calc(${left}px + calc(${width}px / 2) - 40px)`;
// //   control['selectedText'] = selectedText;

// //   document.body.appendChild(control);
// // }

// function strikeThrough(text) {
//   return text
//     .split('')
//     .map(char => char + '\u0336')
//     .join('')
// }

// function removeStrikeThrough(text) {
//   console.log(text)
//   const a = text.replace(/[\u0336]/g, '')
//   return a
// }

// function countStrikedLetters(text, end) {
//   console.log("end" ,end)
//   let index = 0
//   let counter = 0
//   text.split("").map((letter) => {
//     if (letter === '\u0336') {
//       counter++
//     } 
//   })
//   return counter
// }

// function replaceBetween(origin, startIndex, endIndex, insertion) {
//   return origin.substring(0, startIndex) + insertion + origin.substring(endIndex);
// }

// function insertAt(origin, index, insertion) {
//   console.log(origin)
//   console.log("inser at", index)
//   return origin.substring(0, index) + insertion + origin.substring(index)
// }

// window.addEventListener('DOMContentLoaded', (event) => {
// var start, end;
// var el;
// let commentsCount = 1;
// var control = document.importNode(document.querySelector('template').content, true).childNodes[0];
// // var test = document.getElementsByClassName('question')[0]
// // test.addEventListener('pointerdown', oncontroldown, true);
// document.getElementById('submit-comment').onclick = (event) => {
//   const el = document.getElementById('card')
//   const comment = document.createElement('p')
//   comment.className = 'comment'
//   const inputBox = document.getElementById('comment-input')
//   const text = document.createTextNode(`Коментар ${commentsCount}: ${inputBox.value}`)
//   comment.appendChild(text)
//   el.appendChild(comment)
//   document.getElementById('myPopup').style.visibility = 'hidden'
//   inputBox.value = ''
//   commentsCount++;
// }

// document.getElementById('submit-edit').onclick = (event) => {
//   const inputBox = document.getElementById('edit-input')
//   el.innerHTML = insertAt(el.innerHTML, end + countStrikedLetters(el.innerHTML, end) , inputBox.value)
//   console.log(start, end)
//   inputBox.value = ''
//   document.getElementById('edit-popup').style.visibility = 'hidden'
// }

// document.getElementById('cancel-comment').onclick = (event) => {
//   document.getElementById('myPopup').style.visibility = 'hidden'
//   document.getElementById('comment-input').value = ''
// }

// document.getElementById('cancel-edit').onclick = (event) => {
//   console.log(start,end)
//   if (start > end) {
//     let temp = start;
//     start = end;
//     end = temp;
//   }
//   el.innerHTML = replaceBetween(el.innerHTML, start, end * 2, removeStrikeThrough(el.innerHTML.substring(start, end * 2)))
//   document.getElementById('edit-popup').style.visibility = 'hidden'
//   document.getElementById('edit-input').value = ''
// }

// control.addEventListener('pointerdown', oncontroldown, true);
// document.querySelector('p').onpointerup = () => {
//   let selection = document.getSelection(), text = selection.toString();
//   if (text !== "") {
//     let rect = selection.getRangeAt(0).getBoundingClientRect();
//     control.style.top = `calc(${rect.top}px - 48px)`;
//     control.style.left = `calc(${rect.left}px + calc(${rect.width}px / 2) - 40px)`;
//     control['text']= text; 
//     document.body.appendChild(control);
//   }
// }
// function oncontroldown(event) {
//   const clickedElementId = event.path[0].id
//   start = document.getSelection().anchorOffset
//   end = document.getSelection().focusOffset
//   console.log(start, end)
//   if (start > end) {
//     let temp = start;
//     start = end;
//     end = temp;
//   }

//   if (clickedElementId === 'edit') {
//     el = document.getSelection().getRangeAt(0).startContainer.parentElement
//     el.innerHTML = replaceBetween(el.innerHTML, start, end, strikeThrough(el.innerHTML.substring(start, end)))
//     document.getElementById('myPopup').style.visibility = 'hidden'
//     document.getElementById('edit-popup').style.visibility = 'visible'
//   } else {
//     document.getElementById('edit-popup').style.visibility = 'hidden'
//     document.getElementById('myPopup').style.visibility = 'visible'
//   }

//   console.log(document.getSelection());
//   this.remove();
//   document.getSelection().removeAllRanges();
//   event.stopPropagation();
// }
// document.onpointerdown = ()=>{  
//   let control = document.querySelector('#control');
//   if (control !== null) {control.remove();document.getSelection().removeAllRanges();}
// }

// for (const el of document.querySelectorAll('p.editable')) {
//   el.onpointerup = on_selection
// }

// function on_selection() {
//   const selection = document.getSelection()
//   const selectedText = selection.toString()

//   if (!selectedText) {
//     return
//   }

//   const {top, left, width} = selection.getRangeAt(0).getBoundingClientRect();

//   control.style.top = `calc(${top}px - 48px)`;
//   control.style.left = `calc(${left}px + calc(${width}px / 2) - 40px)`;
//   control['selectedText'] = selectedText;

//   document.body.appendChild(control);
// }
// })



async function getQuestions() {
  const response = await fetch('/api/questions.php')
  const {success, data} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching the questions!");
  }

  return data
}

async function getComments(question_id) {
  const response = await fetch(`/api/comments.php?question_id=${question_id}`)
  const {success, data} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching the questions!");
  }

  return data
}

async function getAllComments(question_id) {
  const response = await fetch('/api/comments.php?')
  const {success, data} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching the questions!");
  }

  return data
}

async function sendPost(url, body) {
  return await fetch(url, {
    method: 'POST',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(body) // body data type must match "Content-Type" header
  });
}

async function createCommentRecord(comment, questionId) {
  const url = '/api/comments.php'
  console.log(questionId)
  const response = await sendPost(url, {comment, questionId })

  const as_json = await response.text()
  console.log(as_json)
}

function render() {
  const questions_ol = document.querySelector("ol#questions")
  questions_ol.innerHTML = ""

  for (const question of questions) {
    const li = document.createElement("li")

    const question_input_grp_div = document.createElement("div")
    question_input_grp_div.classList.add("input-group")

    const question_input = document.createElement("span")
    question_input.type = "text"
    question_input.text = "Въпрос"
    question_input.innerHTML = question.question

    question_input_grp_div.append(
      question_input,
    )

    const answers_div = document.createElement("div")

    const answers_ul = document.createElement("ul")
    for (const option of question.options) {
      const answer_li = document.createElement("li")
      const answer_input_grp_div = document.createElement("div")
      answer_input_grp_div.classList.add("input-group")

      const answer_input = document.createElement("span")
      answer_input.className = "question-option"
      answer_input.type = "text"
      answer_input.innerHTML = option.opt

      answer_input_grp_div.append(
        answer_input,
      )

      answer_li.append(
        answer_input_grp_div,
      )

      answers_ul.append(answer_li)
    }

    answers_div.append(
      answers_ul,
    )

    const question_meta_div = document.createElement("div")
    question_meta_div.classList.add("group")

    const question_meta_title = document.createElement("h4")
    question_meta_title.classList.add("group-title")
    question_meta_title.textContent = "Допълнителна информация за въпроса"

    

    question_meta_div.append(question_meta_title)

    question_meta_div.append(
      createInputGroupMeta("Цел на въпроса", question, "purpose_of_question"),
      createInputGroupMeta("Обратна връзка при верен отговор", question, "response_on_correct"),
      createInputGroupMeta("Обратна връзка при грешен отговор", question, "response_on_incorrect"),
      createInputGroupMeta("Забележка", question, "note"),
    )
   
    const add_comment_button = document.createElement('button')
    add_comment_button.innerHTML = 'Добави коментар'
    add_comment_button.className = 'btn-info'
    add_comment_button.id = 'add_comment_button'
    add_comment_button.onclick = (event) => {
      li.append(createCommentArea('Коментар', question, 'test'))
      event.target.parentNode.removeChild(event.target);
      // document.getElementById('add_comment_button').remove()
    }
    currentQuestionComments = comments.filter(comment => comment.questionId === question.id)
    const commentsList = document.createElement('ul')
    for (const fetchedComment of currentQuestionComments) {
      commentsList.className = 'posts'
      const comment = document.createElement('li')
      comment.innerHTML = fetchedComment.comment
      comment.className = 'comment-item'
      commentsList.appendChild(comment)
    }
   


    li.append(
      question_input_grp_div,
      answers_div,

      question_meta_div,
      commentsList,
      add_comment_button
    )

    questions_ol.append(
      li,
    )
  }
}


async function loadQuestions() {
  const fetchedQuestions = await getQuestions()
  questions = fetchedQuestions.map(fq => ({
    id: fq.id,
    question: fq.question,
    purpose_of_question: fq.purpose_of_question,
    options: fq.options,
    correctAnswer: null,
    hardness: fq.hardness,
    response_on_correct: fq.response_on_correct,
    response_on_incorrect: fq.response_on_incorrect,
    note: fq.note,
    type: fq.type,
  }))
  const fetchedComments = await getAllComments()
  comments = fetchedComments.map(comment => ({
    id: comment.id,
    comment: comment.comment,
    questionId: comment.question_id,
    user_id: comment.user_id
  }))
  render()
}

(async () => {
  await loadQuestions()
})()

function createInputGroupMeta(text, question, metaName) {
  const input_grp_div = document.createElement("div")
  input_grp_div.classList.add("input-group")

  const input = document.createElement("span")
  input.id = metaName
  input.type = "text"
  input.placeholder = text
  input.innerHTML = question[metaName] || ''

  input_grp_div.append(
    input,
  )

  return input_grp_div
}

function createCommentArea(text, question, metaName) {
  const input_grp_div = document.createElement("div")
  input_grp_div.classList.add("input-group")

  const input = document.createElement("textarea")
  input.id = metaName
  input.type = "text"
  input.placeholder = text
  input.innerHTML = ''

  const button = document.createElement('button')
  button.textContent = 'Запази'
  button.className = 'btn-info'
  button.onclick = (event) => {
    createCommentRecord(input.value, question.id)
    loadQuestions()
  }

  input_grp_div.append(
    input,
    button
  )

  return input_grp_div
}
