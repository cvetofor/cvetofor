let phoneFields = document.querySelectorAll("[data-mask-tel]");

let phoneMask = Inputmask({
  mask: "+7 (999) 999-99-99",
  placeholder: "",
  showMaskOnHover: false,
  showMaskOnFocus: false,
}).mask(phoneFields);

const numberFields = document.querySelectorAll("[data-mask-number]");

numberFields.forEach(function (field) {
  const numberMask = Inputmask({
    mask: "9",
    repeat: field.dataset.maskNumber,
  }).mask(field);
});

const codeFields = document.querySelectorAll("[data-mask-code]");

const codeMask = Inputmask({
  mask: "9 9 9 - 9 9 9",
  placeholder: "_",
}).mask(codeFields);

const datepickers = document.querySelectorAll("[data-datepicker]");

initDatepicker(datepickers);

function initDatepicker(datepicker) {
  flatpickr.localize(flatpickr.l10ns.ru);
  const config = {
    timeZone: "local",
    dateFormat: window['cvetofor'].config.flatpickr.dateFormat !== undefined ? window['cvetofor'].config.flatpickr.dateFormat : "d.m.Y",
    minDate: window['cvetofor'].config.flatpickr.minDate !== undefined ? window['cvetofor'].config.flatpickr.minDate : "today",
    disableMobile: "true",
    static: true,
    prevArrow: `
      <svg width="7" height="10" viewBox="0 0 7 10" fill="" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.22955 9.53033C6.52244 9.23744 6.52244 8.76256 6.22955 8.46967L2.75988 5L6.22955 1.53033C6.52244 1.23744 6.52244 0.762563 6.22955 0.469669C5.93666 0.176776 5.46178 0.176776 5.16889 0.469669L1.16889 4.46967C0.875995 4.76256 0.875995 5.23744 1.16889 5.53033L5.16889 9.53033C5.46178 9.82322 5.93666 9.82322 6.22955 9.53033Z" fill=""/>
      </svg>
    `,
    nextArrow: `
      <svg width="7" height="10" viewBox="0 0 7 10" fill="" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.770451 9.53033C0.477558 9.23744 0.477558 8.76256 0.770451 8.46967L4.24012 5L0.770451 1.53033C0.477558 1.23744 0.477558 0.762563 0.770451 0.469669C1.06334 0.176776 1.53822 0.176776 1.83111 0.469669L5.83111 4.46967C6.124 4.76256 6.124 5.23744 5.83111 5.53033L1.83111 9.53033C1.53822 9.82322 1.06334 9.82322 0.770451 9.53033Z" fill=""/>
      </svg>
    `,
  }
  if (window['cvetofor'].config.flatpickr.maxDate !== undefined) {
    config.maxDate = window['cvetofor'].config.flatpickr.maxDate;
  }
  datepicker.flatpickr(config);
}
