<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_COOKIE['token'])) {
  header('Location: /pages/login/index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../questions/style.css">
  <link rel="stylesheet" href="style.css">


  <script src="script.js"></script>
</head>

<body class="loggedin">


  <div>
    <!-- <article>
      <h1>Select over the text below</h1>
      <p id="editable">Cascading Style Sheets (CSS) is a style sheet language used for describing the presentation of a document written in a markup language such as HTML. CSS is a cornerstone technology of the World Wide Web, alongside HTML and JavaScript. CSS is designed to enable the separation of presentation and content, including layout, colors, and fonts. This separation can improve content accessibility, provide more flexibility and control in the specification of presentation characteristics. </p>
    </article> -->


    <nav class="navtop">
      <div>
        <h1>Puffin Въпросник</h1>
        <a href="profile.php"><i class="fas fa-user-circle"></i>Моят профил</a>
        <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i>Изход</a>
      </div>
    </nav>
    <div class="content">
      <h2>Рецензия</h2>
      <div id="root" class="generator">
        <div class="group">
          <ol id="questions"></ol>
          <button class="submit-button"> Запази </button>
        </div>
      </div>
    </div>
    <!-- 
    <template><span id="control"><b id="edit"></b><b id="comment"></b></span></template>
    <div class="question card" id="card">
      <p id="editable" class="questionText editable">Hello what's there</p>
      <div class="options">
        <p id="option-one" class="editable">1. Option 1</p>
        <p id="option-two" class="editable">2. Option 2</p>
        <p id="option-three" class="editable">3. Option 3</p>
        <p id="option-four" class="editable">4. Option 4</p>

        <p class="editable">Да се разбере дали човекът отсреща знае какво е предназначението на уеб виртуална реалност</p>
        <p class="editable">Верен отговор!</p>
        <p class="editable">Грешен отговор!</p>
        <p class="editable">https://webvr.info/ - обяснява накратко какво е уеб виртуална реалност и дава отговор на поставения въпрос</p>
      </div>
    </div>

    <div style="text-align:center;">
      <div class="popup">
        <span class="popuptext" id="myPopup">
          Коментар: <input type="text" id="comment-input" />
          <button id="submit-comment"> OK </button>
          <button id="cancel-comment"> Отказ </button>
        </span>
      </div>
    </div>

    <div style="text-align:center;">
      <div class="popup">
        <span class="popuptext" id="edit-popup">
          Редакция: <input type="text" id="edit-input" />
          <button id="submit-edit"> OK </button>
          <button id="cancel-edit"> Отказ </button>
        </span>
      </div>
    </div> -->
    <!--  -->

    <!--  -->
    <!-- <div class="template btn-group">
    <button class="edit-btn"><i title="Suggest edits" class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
    <button class="comment-btn"><i title="Add comment" class="fa fa-plus-square-o" aria-hidden="true"></i></button>
  </div> -->
</body>

</html>