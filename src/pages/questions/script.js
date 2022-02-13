let questions = []

function randomId() {
  return '_' + Math.random().toString(36).substr(2, 9)
}

function createInputGroupMeta(placeholder, span_content) {
  const input_grp_div = document.createElement("div")
  input_grp_div.classList.add("input-group")

  const input = document.createElement("textarea")
  input.onchange = (event) => console.log(event)
  input.type = "text"
  input.placeholder = placeholder

  input_grp_div.append(
    input,
  )

  return input_grp_div
}

function render() {
  const questions_ol = document.querySelector("ol#questions")
  questions_ol.innerHTML = ""

  for (const question of questions) {
    const li = document.createElement("li")

    const question_input_grp_div = document.createElement("div")
    question_input_grp_div.classList.add("input-group")

    const question_input = document.createElement("textarea")
    question_input.onchange = (event) => console.log(event)
    question_input.oninput = (event) => console.log(event)
    question_input.type = "text"
    question_input.placeholder = "Question text"

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
    add_answer_btn.textContent = "Add Answer"
    add_answer_btn.classList.add("btn-info")
    add_answer_btn.onclick = () => addAnswer(question.id)

    const answers_ul = document.createElement("ul")
    for (const answer of question.answers) {
      const answer_li = document.createElement("li")
      const answer_input_grp_div = document.createElement("div")
      answer_input_grp_div.classList.add("input-group")

      const answer_input = document.createElement("textarea")
      answer_input.onchange = (event) => console.log(event)
      answer_input.type = "text"
      answer_input.placeholder = "Answer text"

      const remove_answer_btn = document.createElement("button")
      remove_answer_btn.classList.add("btn-danger")
      remove_answer_btn.onclick = () => removeAnswer(question.id, answer.id)
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
    question_meta_title.textContent = "Question Metadata"

    question_meta_div.append(question_meta_title)

    question_meta_div.append(
      createInputGroupMeta("Purpose Of Question"),
      createInputGroupMeta("Feedback On Correct Answer"),
      createInputGroupMeta("Feedback On Mistake"),
      createInputGroupMeta("Note"),
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
  questions.push({
    id: randomId(),
    question: '',
    questionPoint: '',
    answers: [],
    correctAnswer: null,
    hardness: -1,
    feedbackOnCorrect: '',
    feedbackOnMistake: '',
    note: '',
    question_type: '',
  })

  render()
}

function removeQuestion(questionId) {
  questions = questions.filter(question => question.id !== questionId)

  render()
}

function addAnswer(questionId) {
  const question = questions.find(question => question.id === questionId)

  question.answers.push({
    id: randomId(),
    text: '',
  })

  render()
}

function removeAnswer(questionId, answerId) {
  const question = questions.find(question => question.id === questionId)
  question.answers = question.answers.filter(answer => answer.id !== answerId)

  render()
}
