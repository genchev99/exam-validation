window.addEventListener('DOMContentLoaded', () => {
  const selectReferat = document.querySelector("select#referat")
  selectReferat.onchange = (event) => handleReferatPick(event)

  // Load referats
  loadReferats(selectReferat).then(()=> loadQuestions(selectReferat.selectedOptions[0].getAttribute("referat-id")))
});

async function getQuestions(referatId) {

  const response = await fetch(`/api/questions.php?referat_id=${referatId}`)
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

async function getAllComments() {
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
  await sendPost(url, {comment, questionId })
}




function render() {
  // referats()
  const questions_ol = document.querySelector("ol#questions")
  if (!questions.length) {
    questions_ol.innerHTML = 'Няма добавени въпроси за този реферат. Можеш да добавиш въпроси от "Моите въпроси"'
  } else {
    questions_ol.innerHTML = ""
  }

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
    }

    currentQuestionComments = comments.filter(comment => comment.questionId === question.id)
    const commentsList = document.createElement('ul')
    for (const fetchedComment of currentQuestionComments) {
      commentsList.className = 'posts'
      const comment = document.createElement('li')
      comment.innerHTML = fetchedComment.comment
      comment.className = 'comment-item'

      const name = document.createElement('span')
      name.innerHTML = `${fetchedComment.username}[${fetchedComment.fn}] написа:`
      commentsList.appendChild(name)
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
let question = []
let comments = []

async function loadQuestions(referatId) {
  const fetchedQuestions = await getQuestions(referatId)
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
    userId: comment.user_id,
    username: comment.username,
    fn: comment.faculty_number
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

async function setReferatSelection(referatId) {
  const url = "/api/referats.php"

  const response = await sendPut(url, {
    referatId,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function handleReferatPick(event) {
  console.log(event.target.selectedIndex)
  loadQuestions(event.target.selectedOptions[0].getAttribute("referat-id"))
}

function referats()  {
  const selectReferat = document.getElementById('referat')
  selectReferat.onchange = (event) => handleReferatPick(event)

  // Load referats
  loadReferats(selectReferat)
}

async function loadReferats(selectHandle, referatId) {
  const {data: referats, selected} = await getReferats()
  selectHandle.innerHTML = ""

  for (const referat of referats) {
    const option = document.createElement("option")
    option.textContent = referat.referat_title
    option.id = `referat-${referat.id}`
    option.setAttribute("referat-id", referat.id)

    selectHandle.append(option)
  }

  // selectHandle.selectedIndex = referats.map(referat => referat.id === selected).indexOf(true)
}

async function getReferats() {
  const response = await fetch('/api/referats.php')
  const {success, data, selected} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching referats!");
    throw new Error("referats")
  }

  return {data, selected}
}

async function sendPut(url, body) {
  return await fetch(url, {
    method: 'PUT',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(body) // body data type must match "Content-Type" header
  });
}