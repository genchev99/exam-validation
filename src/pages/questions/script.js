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
    purposeOfQuestion: fq.purpose_of_question,
    options: fq.options,
    correctAnswer: null,
    hardness: fq.hardness,
    responseOnCorrect: fq.response_on_correct,
    responseOnIncorrect: fq.response_on_incorrect,
    note: fq.note,
    type: fq.type,
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

function sendRequest(url, options, successCallback, errorCallback) {
  const request = new XMLHttpRequest();

  request.addEventListener('load', function () {
    console.log(request.responseText)
    const response = JSON.parse(request.responseText);

    if (request.status === 200) {
      successCallback(response);
    } else {
      errorCallback(response);
    }
  });

  request.open(options.method, url, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(options.data);
}

function handleQuestionChange(event, questionId) {
  const question = questions.find(question => question.id === questionId)
  question.question = event.target.value
  console.log(event.target.value)

  sendRequest('/api/questions.php/update', 'POST', `data=${JSON.stringify({test: 1})}`, console.log, console.error);
}

function handleAnswerChange(event, questionId, answerId) {
  const question = questions.find(question => question.id === questionId)
  const answer = question.options.find(answer => answer.id === answerId)

  answer.opt = event.target.value
}

function handleMetaChange(event, questionId, metaName) {
  const question = questions.find(question => question.id === questionId)
  question[metaName] = event.target.value
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
    question_input.placeholder = "Въпрос"
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
    add_answer_btn.textContent = "Добавяне на отговор"
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
      answer_input.placeholder = "Answer text"
      answer_input.value = option.opt

      const remove_answer_btn = document.createElement("button")
      remove_answer_btn.classList.add("btn-danger")
      remove_answer_btn.onclick = () => removeAnswer(question.id, option.id)
      remove_answer_btn.innerHTML = "&times;"

      answer_input_grp_div.append(
        answer_input,
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
    question_meta_title.textContent = "Допълнителна информация за въпроса"

    question_meta_div.append(question_meta_title)

    question_meta_div.append(
      createInputGroupMeta("Purpose Of Question", question, "purposeOfQuestion"),
      createInputGroupMeta("Response On Correct Answer", question, "responseOnCorrect"),
      createInputGroupMeta("Response On Incorrect Answer", question, "responseOnIncorrect"),
      createInputGroupMeta("Note", question, "note"),
    )

    li.append(
      question_input_grp_div,
      answers_div,

      question_meta_div,
    )

    questions_ol.append(
      li,
    )
  }
}

function addQuestion() {
  // questions.push({
  //   id: fq.id,
  //   question: fq.question,
  //   purposeOfQuestion: fq.purpose_of_question,
  //   answers: [],
  //   correctAnswer: null,
  //   hardness: fq.hardness,
  //   responseOnCorrect: fq.response_on_correct,
  //   responseOnIncorrect: fq.response_on_incorrect,
  //   note: fq.note,
  //   type: fq.type,
  // })

  render()
}

function removeQuestion(questionId) {
  questions = questions.filter(question => question.id !== questionId)

  render()
}

function addAnswer(questionId) {
  const question = questions.find(question => question.id === questionId)

  question.options.push({
    id: randomId(),
    opt: '',
  })

  render()
}

function removeAnswer(questionId, answerId) {
  const question = questions.find(question => question.id === questionId)
  question.options = question.options.filter(answer => answer.id !== answerId)

  render()
}
