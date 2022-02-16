async function getUser() {
  const response = await fetch('/api/user.php')
  const {success, data} = await response.json()
  if (!success) {
    alert("Error: There was a problem while fetching profile info!");
    throw new Error("profile")
  }

  return data
}

async function exportQuestionsAsCsv() {
  try {
    await fetch('/api/questions.php?export_csv=1')
      .then(response => response.blob())
      .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = "export.csv"; // hardcoded af
        document.body.appendChild(a); // we need to append the element to the dom -> otherwise it will not work in firefox
        a.click();
        a.remove();  //afterwards we remove the element again
      });
  } catch (err) {
    alert("Error: There was a problem while exporting questions!");
    throw err
  }
}

function handleOnClickExport(event) {
  exportQuestionsAsCsv()
}

window.addEventListener('DOMContentLoaded', () => {
  getUser().then((user) => {
    document.getElementById('name').innerHTML = user.username
    document.getElementById('fn').innerHTML = user.faculty_number
    document.getElementById('created-at').innerHTML = `Дата на регистрация: ${user.created_at}`
  })
});
