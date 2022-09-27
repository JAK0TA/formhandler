import { ReCaptchaSubmit } from './modules/ReCaptchaSubmit';

document.addEventListener('DOMContentLoaded', () => {
  const recaptchaForm = document.querySelector(
    'form.formhandler'
  ) as HTMLFormElement;
  if (null !== recaptchaForm) {
    new ReCaptchaSubmit(recaptchaForm);
  }
});
