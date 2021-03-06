(() => {
  const selectReferat = document.querySelector("select#referat")
  selectReferat.onchange = (event) => handleReferatPick(event)

  // Load referats
  loadReferats(selectReferat)
})();

async function loadReferats(selectHandle) {
  const {data: referats, selected} = await getReferats()
  selectHandle.innerHTML = ""

  for (const referat of referats) {
    const option = document.createElement("option")
    option.textContent = referat.referat_title
    option.id = `referat-${referat.id}`
    option.setAttribute("referat-id", referat.id)

    selectHandle.append(option)
  }

  selectHandle.selectedIndex = referats.map(referat => referat.id === selected).indexOf(true)
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

let questions = []

async function getQuestions() {
  const response = await fetch('/api/questions.php')
  const {success, data} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching your questions!");
  }

  return data
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
    userId: comment.user_id,
    username: comment.username,
    fn: comment.faculty_number
  }))

  render()
}

(async () => {
  await loadQuestions()
})()

function randomId() {
  return '_' + Math.random().toString(36).substr(2, 9)
}

function createInputGroupMeta(placeholder, question, metaName) {
  const input_grp_div = document.createElement("div")
  input_grp_div.classList.add("input-group")

  const input = document.createElement("textarea")
  input.onchange = (event) => handleMetaChange(event, question.id, metaName)
  input.type = "text"
  input.placeholder = placeholder
  input.value = question[metaName]

  input_grp_div.append(
    input,
  )

  return input_grp_div
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

async function sendDelete(url, body) {
  return await fetch(url, {
    method: 'DELETE',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(body) // body data type must match "Content-Type" header
  });
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

async function updateQuestionRecord(questionId, newQuestion) {
  const url = '/api/questions.php'

  const response = await sendPut(url, {
    questionId,
    newValue: newQuestion,
    property: 'question',
  })

  const as_json = await response.text()
  console.log(as_json)
}

function handleQuestionChange(event, questionId) {
  const question = questions.find(question => question.id === questionId)
  const newQuestion = event.target.value
  question.question = newQuestion

  updateQuestionRecord(questionId, newQuestion)
}

async function updateOptionRecord(questionId, optionId, newValue) {
  const url = '/api/options.php'

  const response = await sendPut(url, {
    questionId,
    optionId,
    newValue,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function handleAnswerChange(event, questionId, answerId) {
  const question = questions.find(question => question.id === questionId)
  const answer = question.options.find(answer => answer.id === answerId)
  const newValue = event.target.value

  answer.opt = newValue
  updateOptionRecord(question.id, answer.id, newValue)
}

async function updateMetaRecord(questionId, newValue, property) {
  const url = '/api/questions.php'

  const response = await sendPut(url, {
    questionId,
    newValue,
    property,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function handleMetaChange(event, questionId, metaName) {
  const question = questions.find(question => question.id === questionId)
  const newValue = event.target.value
  question[metaName] = newValue

  updateMetaRecord(questionId, newValue, metaName)
}

async function updateIsOptionCorrect(optionId, isCorrect) {
  const url = '/api/options.php'

  const response = await sendPut(url, {
    optionId,
    isCorrect,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function handleToggle(event, optionId) {
  updateIsOptionCorrect(optionId, event.target.checked)
}

function render() {
  const questions_ol = document.querySelector("ol#questions")
  questions_ol.innerHTML = ""

  for (const question of questions) {
    const li = document.createElement("li")

    const question_input_grp_div = document.createElement("div")
    question_input_grp_div.classList.add("input-group")

    const question_input = document.createElement("textarea")
    question_input.onchange = (event) => handleQuestionChange(event, question.id)
    question_input.type = "text"
    question_input.placeholder = "????????????"
    question_input.value = question.question

    const remove_question_btn = document.createElement("button")
    remove_question_btn.classList.add("btn-danger")
    remove_question_btn.onclick = () => removeQuestion(question.id)
    remove_question_btn.innerHTML = "&times;"

    question_input_grp_div.append(
      question_input,
      remove_question_btn,
    )

    const answers_div = document.createElement("div")
    const add_answer_btn = document.createElement("button")
    add_answer_btn.textContent = "???????????????? ???? ??????????????"
    add_answer_btn.classList.add("btn-info")
    add_answer_btn.onclick = () => addAnswer(question.id)

    const answers_ul = document.createElement("ul")
    for (const option of question.options) {
      const answer_li = document.createElement("li")
      const answer_input_grp_div = document.createElement("div")
      answer_input_grp_div.classList.add("input-group")

      const answer_input = document.createElement("textarea")
      answer_input.onchange = (event) => handleAnswerChange(event, question.id, option.id)
      answer_input.type = "text"
      answer_input.placeholder = "????????????????"
      answer_input.value = option.opt

      const is_correct_toggle_input = document.createElement("input")
      is_correct_toggle_input.id = `option-${option.id}`
      is_correct_toggle_input.checked = option.is_correct
      is_correct_toggle_input.type = "checkbox"
      is_correct_toggle_input.onclick = (event) => handleToggle(event, option.id)

      const is_correct_toggle_label = document.createElement("label")
      is_correct_toggle_label.setAttribute("for", `option-${option.id}`)
      is_correct_toggle_label.classList.add("check-trail")

      const is_correct_l_span = document.createElement("span")
      is_correct_l_span.classList.add("check-handler")

      is_correct_toggle_label.append(is_correct_l_span)

      const toggle_wrapper_div = document.createElement("div")
      toggle_wrapper_div.append(
        is_correct_toggle_input,
        is_correct_toggle_label,
      )

      const remove_answer_btn = document.createElement("button")
      remove_answer_btn.classList.add("btn-danger")
      remove_answer_btn.classList.add("option")
      remove_answer_btn.onclick = () => removeAnswer(question.id, option.id)
      remove_answer_btn.innerHTML = "&times;"

      answer_input_grp_div.append(
        answer_input,
        toggle_wrapper_div,
        remove_answer_btn,
      )

      answer_li.append(
        answer_input_grp_div,
      )

      answers_ul.append(answer_li)
    }

    answers_div.append(
      add_answer_btn,
      answers_ul,
    )

    const question_meta_div = document.createElement("div")
    question_meta_div.classList.add("group")

    const question_meta_title = document.createElement("h4")
    question_meta_title.classList.add("group-title")
    question_meta_title.textContent = "???????????????????????? ???????????????????? ???? ??????????????"

    question_meta_div.append(question_meta_title)

    question_meta_div.append(
      createInputGroupMeta("?????? ???? ??????????????", question, "purpose_of_question"),
      createInputGroupMeta("?????????????? ???????????? ?????? ?????????? ??????????????", question, "response_on_correct"),
      createInputGroupMeta("?????????????? ???????????? ?????? ???????????? ??????????????", question, "response_on_incorrect"),
      createInputGroupMeta("??????????????????", question, "note"),
    )

    const add_comment_button = document.createElement('button')
    add_comment_button.innerHTML = '???????????? ????????????????'
    add_comment_button.className = 'btn-info'
    add_comment_button.id = 'add_comment_button'
    add_comment_button.onclick = (event) => {
      li.append(createCommentArea('????????????????', question, 'test'))
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
      name.innerHTML = `${fetchedComment.username}[${fetchedComment.fn}] ????????????:`
      commentsList.appendChild(name)
      commentsList.appendChild(comment)
    }


    li.append(
      question_input_grp_div,
      answers_div,

      question_meta_div,
      commentsList,
      add_comment_button,
    )

    questions_ol.append(
      li,
    )
  }
}

async function createQuestionRecord() {
  const url = '/api/questions.php'

  const response = await sendPost(url, {})

  const as_json = await response.text()
  console.log(as_json)
}

function addQuestion() {
  createQuestionRecord().then(() => loadQuestions())
}

async function deleteQuestionRecord(questionId) {
  const url = '/api/questions.php'

  const response = await sendDelete(url, {
    questionId,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function removeQuestion(questionId) {
  deleteQuestionRecord(questionId).then(() => loadQuestions())
}

async function createOptionRecord(questionId) {
  const url = '/api/options.php'

  const response = await sendPost(url, {questionId})

  const as_json = await response.text()
  console.log(as_json)
}

function addAnswer(questionId) {
  createOptionRecord(questionId).then(() => loadQuestions())
}

async function deleteOptionRecord(optionId) {
  const url = '/api/options.php'

  const response = await sendDelete(url, {
    optionId,
  })

  const as_json = await response.text()
  console.log(as_json)
}

function removeAnswer(questionId, answerId) {
  deleteOptionRecord(answerId).then(() => loadQuestions())
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
  setReferatSelection(event.target.selectedOptions[0].getAttribute("referat-id"))
    .then(() => loadReferats)
    .then(() => loadQuestions())
}

async function getAllComments() {
  const response = await fetch('/api/comments.php?')
  const {success, data} = await response.json()

  if (!success) {
    alert("Error: There was a problem while fetching the questions!");
  }

  return data
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
  button.textContent = '????????????'
  button.className = 'btn-info'
  button.onclick = (event) => {
    createCommentRecord(input.value, question.id).then(() => loadQuestions())
  }

  input_grp_div.append(
    input,
    button
  )

  return input_grp_div
}

async function createCommentRecord(comment, questionId) {
  const url = '/api/comments.php'
  await sendPost(url, {comment, questionId})
}

async function download(format) {
  if (!['json', 'html'].includes(format)) {
    alert("Only json and html support as export")
    throw new Error("")
  }

  await fetch(`/api/questions.php?export=1&format=${format}`)
    .then(response => response.blob())
    .then(blob => {
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `export.${format}`; // hardcoded af
      document.body.appendChild(a); // we need to append the element to the dom -> otherwise it will not work in firefox
      a.click();
      a.remove();  //afterwards we remove the element again
    });
}

function handleDownloadAsJsonClick() {
  download('json')
}

function handleDownloadAsHtmlClick() {
  download('html')
}
