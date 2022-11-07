window.onload = () => {
  const emailInput = document.querySelector("input[name=email]");
  let emailValue = emailInput.value.trim();

  checkContent(emailValue, emailInput);

  emailInput.addEventListener("keyup", () => {
    emailValue = emailInput.value.trim();
    checkContent(emailValue, emailInput);
  })


  const allElementsError = document.querySelectorAll('.field.error');

  allElementsError.forEach(element => {
    const inputEl = element.childNodes[0];
    const messageErrorEl = element.childNodes[2];

    inputEl.addEventListener('keyup', function removeError() {
      element.classList.remove('error');
      element.removeChild(messageErrorEl);

      inputEl.removeEventListener('keyup', removeError);
    });
  });
};

function checkContent(emailValue, emailInput) {
  if (emailValue != "") {
    emailInput.classList.add("hasContent");
  } else {
    emailInput.classList.remove("hasContent");
  }
}