async function getUser() {
  const response = await fetch('/api/user.php')
  const {success, data} = await response.json()
  if (!success) {
    alert("Error: There was a problem while fetching referats!");
    throw new Error("referats")
  }

  return data
}


getUser().then((user) => {
  document.getElementById('name').innerHTML = user.username
  document.getElementById('fn'). innerHTML = user.faculty_number
  document.getElementById('created-at').innerHTML = `Дата на регистрация: ${user.created_at}`
  
})