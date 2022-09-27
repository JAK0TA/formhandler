import { load } from 'recaptcha-v3';

export class ReCaptchaSubmit {
  private container: HTMLFormElement;
  private captchaInput: HTMLInputElement;
  private siteKey: string;

  constructor(container: HTMLFormElement) {
    this.container = container;
    this.captchaInput = this.container.querySelector(
      '#ReCaptchaField'
    ) as HTMLInputElement;
    this.siteKey = String(this.captchaInput.dataset.sitekey);

    this.container
      .querySelector('[type="submit"]')
      ?.addEventListener('click', (e) => this.handleClick(e));
  }

  private handleClick(e: Event) {
    console.log('triggered!');
    e.preventDefault();
    load(this.siteKey).then((recaptcha) => {
      recaptcha.execute('submit').then((token) => {
        console.log(token);
        this.captchaInput.value = token;

        this.container.submit();
      });
    });
  }
}
