(function () {
  /**
   * Get the login button
   */
  const login = document.querySelector('form#login-form > input[type=submit]');

  /**
   * Listen for click event on the login button
   */
  login.addEventListener('click', sendForm);
})();

/**
 * Sends a http request with callbacks
 * @param url
 * @param options
 * @param successCallback
 * @param errorCallback
 */
function sendRequest(url, options, successCallback, errorCallback) {
  const request = new XMLHttpRequest();

  request.addEventListener('load', function() {
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

/**
 * Handle the click event by sending an asynchronous request to the server
 * @param {*} event
 */
function sendForm(event) {
  /**
   * Prevent the default behavior of the clicking the form submit button
   */
  event.preventDefault();

  /**
   * Get the values of the input fields
   */
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  /**
   * Send POST request with user's data to api.php/login
   */
  sendRequest(
    '/api/login.php',
    {
      method: 'POST',
      data: `data=${JSON.stringify({
        username,
        password,
      })}`
    },
    load,
    console.error
  );
}

/**
 * Handle the received response from the server
 * If there were no errors found on validation, the index.html is loaded.
 * Else the errors are displayed to the user.
 * @param {*} response
 */
function load(response) {
  console.log(response)
  if (response.success) {
    window.location = 'index.html';
  } else {
    const errors = document.getElementById('errors');
    errors.innerHTML = response.error;
    errors.style.display = "block";
  }
}
