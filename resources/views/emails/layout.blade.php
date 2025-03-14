<!DOCTYPE html>
<html lang="ru">

<head>
  <style>
    main h1,
    main h2,
    main h3,
    main h4 {
      margin: 0;
    }

    main h1,
    main .h1,
    main h2,
    main .h2,
    main h3,
    main .h3 {
      display: block;
      font-family: "RobotoFlex", Arial, sans-serif;
      font-weight: 600;
      font-stretch: 120%;
      font-variation-settings: "wdth" 120, "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      color: #1a1c18;
    }

    main h1--white,
    main .h1--white,
    main h2--white,
    main .h2--white,
    main h3--white,
    main .h3--white {
      color: #ffffff;
    }

    main h1,
    main .h1 {
      font-size: 48px;
      line-height: 1.16;
    }

    @media screen and (max-width: 991px) {

      main h1,
      main .h1 {
        font-size: 36px;
      }
    }

    main h2,
    main .h2 {
      font-size: 36px;
      line-height: 1.16;
      padding: 0 20px;
      margin-bottom: 20px;
    }

    @media screen and (max-width: 991px) {

      main h2,
      main .h2 {
        font-size: 28px;
        line-height: 118%;
      }
    }

    main h3,
    main .h3 {
      font-size: 28px;
      line-height: 118%;
      padding: 0 20px;
      margin-bottom: 20px;
    }

    @media screen and (max-width: 991px) {

      main h3,
      main .h3 {
        font-size: 24px;
        line-height: 1.16;
      }
    }

    @font-face {
      font-family: "RobotoFlex";
      src: url("../fonts/RobotoFlex.woff2") format("woff2");
      font-display: swap;
    }

    body *:not(svg):not(svg *):not(a):not(img):not(button):not(strong):not(h1):not(h2):not(h3):not(h4):not(hr) {
      all: unset;
      display: revert;
      list-style: none;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
    }

    body *:not(svg):not(svg *):not(a):not(img):not(button):not(strong):not(h1):not(h2):not(h3):not(h4):not(hr) ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
      background-color: #eff1f2;
      border-radius: 10px;
    }

    body *:not(svg):not(svg *):not(a):not(img):not(button):not(strong):not(h1):not(h2):not(h3):not(h4):not(hr) ::-webkit-scrollbar-thumb {
      outline: none;
      background-clip: padding-box;
      background-color: #bfc8cb;
      border-radius: 10px;
    }

    body * {
      outline: none;
    }

    a {
      text-decoration: none;
      color: unset;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    button {
      cursor: pointer;
      background-color: transparent;
      border: none;
      font-family: "RobotoFlex", Arial, sans-serif;
      font-size: inherit;
      font-weight: 500;
      line-height: 1.25;
      font-stretch: 150%;
      font-variation-settings: "wdth" 150, "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738;
      padding: 0;
    }

    img {
      display: block;
      width: auto;
      max-width: 100%;
    }

    .hidden {
      display: none !important;
    }

    body {
      min-height: 100vh;
      position: relative;
      font-style: normal;
      height: 100%;
      font-family: "RobotoFlex", Arial, sans-serif;
      font-weight: 500;
      font-size: 16px;
      line-height: 1.25;
      font-stretch: 150%;
      font-variation-settings: "wdth" 150, "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738;
      color: #1a1c18;
      background-color: #f8f7f7;
      overflow-x: hidden;
    }

    html {
      height: auto;
      -webkit-text-size-adjust: none;
    }

    html.disable-scrolling {
      overflow: hidden;
      margin-right: calc(-1 * (100vw - 100%));
    }

    html,
    body {
      min-height: 100vh;
      -webkit-font-variant-ligatures: no-common-ligatures;
      font-variant-ligatures: no-common-ligatures;
      text-rendering: optimizeLegibility;
      -webkit-font-smoothing: antialiased;
      scroll-behavior: smooth;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      margin: 0;
      position: relative;
    }

    .main,
    .page {
      -webkit-box-flex: 1;
      -ms-flex: 1 1 auto;
      flex: 1 1 auto;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .container {
      position: relative;
      margin: 0 auto;
      width: 100%;
      padding: 0 20px;
      max-width: 1280px;
    }

    @media screen and (max-width: 767px) {
      .container {
        padding: 0 10px;
        max-width: inherit;
      }
    }

    .section {
      margin-top: 60px;
    }

    @media screen and (max-width: 767px) {
      .section {
        margin-top: 40px;
      }
    }

    .section:last-child {
      margin-bottom: 60px;
    }

    .section--width-two-thirds {
      width: calc(75% - 20px);
    }

    .section--width-quarter {
      width: calc(25% - 20px);
    }

    .section--margin-top-40 {
      margin-top: 40px;
    }

    .box__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .box__wrap>.box {
      -webkit-box-flex: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
    }

    .box {
      width: 100%;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 24px;
    }

    .box--no-margin {
      margin-bottom: 0;
    }

    .box--padding-20 {
      padding: 20px;
    }

    .box--padding-32 {
      padding: 32px;
    }

    @media screen and (max-width: 991px) {
      .box--padding-32 {
        padding: 20px;
      }
    }

    .box--padding-40 {
      padding: 40px;
    }

    @media screen and (max-width: 991px) {
      .box--padding-40 {
        padding: 30px;
      }
    }

    .box--border-radius-20 {
      border-radius: 20px;
    }

    .box--border-radius-36 {
      border-radius: 36px;
    }

    .box:not(:last-child):not(.box--no-margin) {
      margin-bottom: 20px;
    }

    .main-cols__wrap {
      margin-top: 60px;
      margin-bottom: 60px;
    }

    @media screen and (max-width: 991px) {
      .main-cols__wrap {
        margin-top: 40px;
      }
    }

    .main-cols__wrap>.container {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 38px;
    }

    @media screen and (max-width: 991px) {
      .main-cols__wrap>.container {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 0;
      }
    }

    .main-cols__wrap>.container>.main-col,
    .main-cols__wrap>.container>.side-col {
      width: 100%;
    }

    .main-cols__wrap>.container>.main-col .section:first-child,
    .main-cols__wrap>.container>.side-col .section:first-child {
      margin-top: 0;
    }

    .main-cols__wrap>.container>.main-col .section:last-child,
    .main-cols__wrap>.container>.side-col .section:last-child {
      margin-bottom: 0;
    }

    @media screen and (max-width: 991px) {
      .main-cols__wrap>.container>.main-col+.side-col {
        margin-top: 60px;
      }
    }

    @media screen and (max-width: 991px) {
      .main-cols__wrap>.container>.side-col+.main-col {
        margin-top: 60px;
      }
    }

    .main-cols__wrap>.container>.side-col {
      max-width: 342px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    @media screen and (max-width: 991px) {
      .main-cols__wrap>.container>.side-col {
        max-width: 100%;
      }
    }

    .video {
      width: 100%;
      height: 0;
      padding-bottom: 56.25%;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
    }

    .video--overlay::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.3);
      z-index: 2;
    }

    .video iframe,
    .video video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
      outline: none;
    }

    .video img {
      width: 100%;
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .video__title {
      font-size: 14px;
      font-weight: 300;
      text-align: center;
      color: #6f797b;
      max-width: 640px;
      margin: 14px auto 0;
    }

    .breadcrumbs {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }

    .breadcrumbs__item {
      position: relative;
      margin: 0 25px 10px 0;
      color: #1a1c18;
      text-decoration: none;
      font-weight: 500;
      font-size: 12px;
      line-height: 1.25;
    }

    .breadcrumbs__item a {
      color: #6f797b;
    }

    .breadcrumbs__item::before {
      content: "/";
      position: absolute;
      width: 1px;
      height: 100%;
      top: 0;
      right: -12px;
      color: #6f797b;
    }

    .breadcrumbs__item:last-child {
      margin-right: 0;
    }

    .breadcrumbs__item:last-child::before {
      display: none;
    }

    .form__thanks {
      display: none;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 20px;
    }

    .fields {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 20px;
    }

    .fields--gap-20-30 {
      gap: 20px 30px;
    }

    .fields--gap-20-30 .inputholder--width-half,
    .fields--gap-20-30 .inputholder__input--width-half {
      width: calc(50% - 15px);
    }

    @media screen and (max-width: 575px) {

      .fields--gap-20-30 .inputholder--width-half,
      .fields--gap-20-30 .inputholder__input--width-half {
        width: 100%;
      }
    }

    .fields--gap-20-30 .inputholder--width-quarter,
    .fields--gap-20-30 .inputholder__input--width-quarter {
      width: calc(25% - 23px);
    }

    @media screen and (max-width: 575px) {

      .fields--gap-20-30 .inputholder--width-quarter,
      .fields--gap-20-30 .inputholder__input--width-quarter {
        width: 100%;
      }
    }

    .fields--margin-bottom-40 {
      margin-bottom: 40px;
    }

    .inputholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 12px;
      width: 100%;
      position: relative;
    }

    .inputholder--width-half {
      width: calc(50% - 10px);
    }

    @media screen and (max-width: 575px) {
      .inputholder--width-half {
        width: 100%;
      }
    }

    .inputholder--width-quarter {
      width: calc(25% - 10px);
    }

    @media screen and (max-width: 575px) {
      .inputholder--width-quarter {
        width: 100%;
      }
    }

    .inputholder__input,
    .inputholder__textarea {
      font-family: "RobotoFlex", Arial, sans-serif;
    }

    .inputholder__input {
      width: 100%;
      padding: 11px 10px;
      background-color: #ffffff;
      border-radius: 12px;
      border: 2px solid #dbe4e7;
      font-size: 14px;
      font-weight: 500;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738;
      -webkit-transition: border-color ease 0.3s;
      -o-transition: border-color ease 0.3s;
      transition: border-color ease 0.3s;
    }

    .inputholder__input:not(.inputholder__input--readonly):focus {
      border-color: #ca4592;
      outline: none;
    }

    .inputholder__input::-webkit-input-placeholder {
      color: #bfc8cb;
    }

    .inputholder__input::-moz-placeholder {
      color: #bfc8cb;
    }

    .inputholder__input:-ms-input-placeholder {
      color: #bfc8cb;
    }

    .inputholder__input::-ms-input-placeholder {
      color: #bfc8cb;
    }

    .inputholder__input::placeholder {
      color: #bfc8cb;
    }

    .inputholder__input--readonly {
      color: #bfc8cb;
      background-color: #f8f7f7;
    }

    .inputholder__input.error {
      padding-right: 35px;
      border-color: #ba1a1a;
      background-repeat: no-repeat;
      background-position: top 50% right 11px;
      background-size: 15px;
      background-image: url(../img/image/exclamation-mark.svg);
    }

    .inputholder__input.error::-webkit-input-placeholder {
      color: #ffffff;
    }

    .inputholder__input.error::-moz-placeholder {
      color: #ffffff;
    }

    .inputholder__input.error:-ms-input-placeholder {
      color: #ffffff;
    }

    .inputholder__input.error::-ms-input-placeholder {
      color: #ffffff;
    }

    .inputholder__input.error::placeholder {
      color: #ffffff;
    }

    .inputholder__textarea {
      width: 100%;
      min-height: 100px;
      padding: 11px 10px;
      border-radius: 12px;
      border: 2px solid #dbe4e7;
      font-size: 14px;
      font-weight: 500;
      display: block;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .inputholder__textarea:not(.inputholder__textarea--readonly):focus {
      border-color: #ca4592;
      outline: none;
    }

    .inputholder__textarea::-webkit-input-placeholder {
      font-size: 14px;
      color: #bfc8cb;
    }

    .inputholder__textarea::-moz-placeholder {
      font-size: 14px;
      color: #bfc8cb;
    }

    .inputholder__textarea:-ms-input-placeholder {
      font-size: 14px;
      color: #bfc8cb;
    }

    .inputholder__textarea::-ms-input-placeholder {
      font-size: 14px;
      color: #bfc8cb;
    }

    .inputholder__textarea::placeholder {
      font-size: 14px;
      color: #bfc8cb;
    }

    .inputholder__textarea--readonly {
      color: #bfc8cb;
      background-color: #f8f7f7;
    }

    .inputholder__textarea.error {
      border-color: #ba1a1a;
    }

    .inputholder__textarea.error::-webkit-input-placeholder {
      color: #ffffff;
    }

    .inputholder__textarea.error::-moz-placeholder {
      color: #ffffff;
    }

    .inputholder__textarea.error:-ms-input-placeholder {
      color: #ffffff;
    }

    .inputholder__textarea.error::-ms-input-placeholder {
      color: #ffffff;
    }

    .inputholder__textarea.error::placeholder {
      color: #ffffff;
    }

    header .checkbox,
    main .checkbox,
    footer .checkbox,
    .modal .checkbox {
      display: block;
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
      min-height: 28px;
      position: relative;
      cursor: pointer;
    }

    header .checkbox input[type=checkbox],
    main .checkbox input[type=checkbox],
    footer .checkbox input[type=checkbox],
    .modal .checkbox input[type=checkbox] {
      width: 1px;
      height: 1px;
      position: absolute;
      opacity: 0;
    }

    @media (any-hover: hover) {

      header .checkbox input[type=checkbox]:hover+label:before,
      header .checkbox input[type=checkbox]:hover+span:before,
      main .checkbox input[type=checkbox]:hover+label:before,
      main .checkbox input[type=checkbox]:hover+span:before,
      footer .checkbox input[type=checkbox]:hover+label:before,
      footer .checkbox input[type=checkbox]:hover+span:before,
      .modal .checkbox input[type=checkbox]:hover+label:before,
      .modal .checkbox input[type=checkbox]:hover+span:before {
        border-color: #bfc8cb;
      }
    }

    header .checkbox input[type=checkbox]+label,
    header .checkbox input[type=checkbox]+span,
    main .checkbox input[type=checkbox]+label,
    main .checkbox input[type=checkbox]+span,
    footer .checkbox input[type=checkbox]+label,
    footer .checkbox input[type=checkbox]+span,
    .modal .checkbox input[type=checkbox]+label,
    .modal .checkbox input[type=checkbox]+span {
      display: -webkit-inline-box;
      display: -ms-inline-flexbox;
      display: inline-flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      position: relative;
      padding-left: 38px;
      min-height: 28px;
      font-size: 14px;
      font-weight: 300;
      cursor: pointer;
    }

    header .checkbox input[type=checkbox]+label:before,
    header .checkbox input[type=checkbox]+span:before,
    main .checkbox input[type=checkbox]+label:before,
    main .checkbox input[type=checkbox]+span:before,
    footer .checkbox input[type=checkbox]+label:before,
    footer .checkbox input[type=checkbox]+span:before,
    .modal .checkbox input[type=checkbox]+label:before,
    .modal .checkbox input[type=checkbox]+span:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 24px;
      height: 24px;
      background-color: #ffffff;
      border: 2px solid #dbe4e7;
      border-radius: 8px;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    header .checkbox input[type=checkbox]+label:after,
    header .checkbox input[type=checkbox]+span:after,
    main .checkbox input[type=checkbox]+label:after,
    main .checkbox input[type=checkbox]+span:after,
    footer .checkbox input[type=checkbox]+label:after,
    footer .checkbox input[type=checkbox]+span:after,
    .modal .checkbox input[type=checkbox]+label:after,
    .modal .checkbox input[type=checkbox]+span:after {
      content: "";
      position: absolute;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    header .checkbox input[type=checkbox]+label:after,
    header .checkbox input[type=checkbox]+span:after,
    main .checkbox input[type=checkbox]+label:after,
    main .checkbox input[type=checkbox]+span:after,
    footer .checkbox input[type=checkbox]+label:after,
    footer .checkbox input[type=checkbox]+span:after,
    .modal .checkbox input[type=checkbox]+label:after,
    .modal .checkbox input[type=checkbox]+span:after {
      top: 5px;
      left: 5px;
      width: 17px;
      height: 17px;
      background-color: #ca4592;
      border-radius: 5px;
    }

    header .checkbox input[type=checkbox]:not(:checked)+label:after,
    header .checkbox input[type=checkbox]:not(:checked)+span:after,
    main .checkbox input[type=checkbox]:not(:checked)+label:after,
    main .checkbox input[type=checkbox]:not(:checked)+span:after,
    footer .checkbox input[type=checkbox]:not(:checked)+label:after,
    footer .checkbox input[type=checkbox]:not(:checked)+span:after,
    .modal .checkbox input[type=checkbox]:not(:checked)+label:after,
    .modal .checkbox input[type=checkbox]:not(:checked)+span:after {
      -webkit-transform: scale(0);
      -ms-transform: scale(0);
      transform: scale(0);
    }

    header .checkbox input[type=checkbox]:checked+label:before,
    header .checkbox input[type=checkbox]:checked+span:before,
    main .checkbox input[type=checkbox]:checked+label:before,
    main .checkbox input[type=checkbox]:checked+span:before,
    footer .checkbox input[type=checkbox]:checked+label:before,
    footer .checkbox input[type=checkbox]:checked+span:before,
    .modal .checkbox input[type=checkbox]:checked+label:before,
    .modal .checkbox input[type=checkbox]:checked+span:before {
      border-color: #ca4592;
    }

    header .checkbox input[type=checkbox]:checked+label:after,
    header .checkbox input[type=checkbox]:checked+span:after,
    main .checkbox input[type=checkbox]:checked+label:after,
    main .checkbox input[type=checkbox]:checked+span:after,
    footer .checkbox input[type=checkbox]:checked+label:after,
    footer .checkbox input[type=checkbox]:checked+span:after,
    .modal .checkbox input[type=checkbox]:checked+label:after,
    .modal .checkbox input[type=checkbox]:checked+span:after {
      -webkit-transform: scale(1);
      -ms-transform: scale(1);
      transform: scale(1);
    }

    [data-datepicker]+.error-text {
      margin-top: 8px;
    }

    .error-text {
      font-size: 12px;
      font-weight: 300;
      line-height: 1.25;
      color: #ba1a1a;
      margin-top: -4px;
      display: none;
    }

    .error-text--backend {
      display: block;
    }

    .error {
      border-color: #da1b1b;
    }

    .error+.error-text {
      display: block;
    }

    .flatpickr-input {
      padding-right: 50px;
      background-repeat: no-repeat;
      background-position: top 50% right 12px;
      background-size: 16px;
      background-image: url(../img/image/calendar.svg);
      -webkit-transition: border-color ease 0.3s;
      -o-transition: border-color ease 0.3s;
      transition: border-color ease 0.3s;
    }

    .flatpickr-input.active {
      background-image: url(../img/image/cross-purple.svg);
    }

    .flatpickr-calendar {
      width: 330px;
      padding: 8px 8px 14px 8px;
      border-radius: 12px;
    }

    @media screen and (max-width: 575px) {
      .flatpickr-calendar {
        width: 260px;
      }
    }

    .flatpickr-calendar::before,
    .flatpickr-calendar::after {
      display: none;
    }

    .flatpickr-calendar.static {
      top: calc(100% + 10px);
    }

    .flatpickr-day {
      max-width: 34px;
      height: 34px;
      line-height: 34px;
      color: #1a1c18;
      border-radius: 12px;
    }

    @media screen and (max-width: 575px) {
      .flatpickr-day {
        max-width: 30px;
        height: 30px;
        line-height: 30px;
      }
    }

    .flatpickr-day.today {
      border-color: #ca4592;
    }

    .flatpickr-current-month {
      width: auto;
      position: relative;
      top: auto;
      bottom: auto;
      left: auto;
      right: auto;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-current-month input.cur-year {
      font-size: 14px;
    }

    .flatpickr-current-month .numInputWrapper {
      display: none;
    }

    .flatpickr-months {
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      margin-bottom: 2px;
    }

    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      position: static;
      top: auto;
      bottom: auto;
      left: auto;
      right: auto;
      width: 16px;
      height: 38px;
      padding: 0;
    }

    .flatpickr-months .flatpickr-prev-month:hover svg,
    .flatpickr-months .flatpickr-next-month:hover svg {
      fill: #ca4592;
    }

    .flatpickr-months .flatpickr-prev-month svg,
    .flatpickr-months .flatpickr-next-month svg {
      width: 7px;
      height: 10px;
    }

    .flatpickr-months .flatpickr-month {
      -webkit-box-flex: 0;
      -ms-flex: none;
      flex: none;
    }

    .flatpickr-rContainer {
      margin: 0 auto;
    }

    @media screen and (max-width: 575px) {
      .flatpickr-rContainer {
        width: 234px;
      }
    }

    .flatpickr-weekdays {
      margin-bottom: 8px;
    }

    @media screen and (max-width: 575px) {
      .flatpickr-weekdays .flatpickr-weekdaycontainer {
        gap: 4px;
      }
    }

    span.flatpickr-weekday {
      min-width: 34px;
      height: 34px;
      line-height: 34px;
      color: #1a1c18;
    }

    @media screen and (max-width: 575px) {
      span.flatpickr-weekday {
        min-width: 30px;
        max-width: 30px;
        height: 30px;
        line-height: 30px;
      }
    }

    @media screen and (max-width: 575px) {
      .flatpickr-days {
        width: 234px;
      }
    }

    .dayContainer {
      gap: 8px;
    }

    @media screen and (max-width: 575px) {
      .dayContainer {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        gap: 4px;
      }
    }

    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange,
    .flatpickr-day.selected.inRange,
    .flatpickr-day.startRange.inRange,
    .flatpickr-day.endRange.inRange,
    .flatpickr-day.selected:focus,
    .flatpickr-day.startRange:focus,
    .flatpickr-day.endRange:focus,
    .flatpickr-day.selected:hover,
    .flatpickr-day.startRange:hover,
    .flatpickr-day.endRange:hover,
    .flatpickr-day.selected.prevMonthDay,
    .flatpickr-day.startRange.prevMonthDay,
    .flatpickr-day.endRange.prevMonthDay,
    .flatpickr-day.selected.nextMonthDay,
    .flatpickr-day.startRange.nextMonthDay,
    .flatpickr-day.endRange.nextMonthDay {
      background: #ca4592;
      border-color: #ca4592;
    }

    .flatpickr-day.inRange,
    .flatpickr-day.prevMonthDay.inRange,
    .flatpickr-day.nextMonthDay.inRange,
    .flatpickr-day.today.inRange,
    .flatpickr-day.prevMonthDay.today.inRange,
    .flatpickr-day.nextMonthDay.today.inRange,
    .flatpickr-day:hover,
    .flatpickr-day.prevMonthDay:hover,
    .flatpickr-day.nextMonthDay:hover,
    .flatpickr-day:focus,
    .flatpickr-day.prevMonthDay:focus,
    .flatpickr-day.nextMonthDay:focus {
      color: #ca4592;
      background: #ffeaf2;
      border-color: #ffeaf2;
    }

    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover,
    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay,
    .flatpickr-day.notAllowed,
    .flatpickr-day.notAllowed.prevMonthDay,
    .flatpickr-day.notAllowed.nextMonthDay {
      color: #bfc8cb;
    }

    .form__policy,
    .form__info {
      display: block;
      font-weight: 300;
      font-size: 12px;
      line-height: 1.25;
    }

    .suggest-dropdown>ymaps {
      z-index: 3;
    }

    .suggest-dropdown>ymaps[style*="display: block"] .ymaps-2-1-79-search__suggest,
    .suggest-dropdown>ymaps[style*="display:block"] .ymaps-2-1-79-search__suggest {
      padding: 8px;
    }

    .suggest-dropdown .ymaps-2-1-79-search__suggest {
      font-family: "RobotoFlex", Arial, sans-serif;
      font-size: 14px;
      font-weight: 500;
      line-height: 1.25;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738;
      font-stretch: 150%;
      top: 10px;
      background-color: #fffefe;
      -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08) !important;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08) !important;
      border-radius: 12px;
      border: none;
      overflow: hidden;
    }

    .suggest-dropdown .ymaps-2-1-79-suggest-item:not(:last-child) {
      margin-bottom: 4px;
    }

    .suggest-dropdown .ymaps-2-1-79-search__suggest-item {
      padding: 14px 15px;
      border-radius: 12px;
      color: #1a1c18;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 575px) {
      .suggest-dropdown .ymaps-2-1-79-search__suggest-item {
        padding: 5px;
      }
    }

    .suggest-dropdown .ymaps-2-1-79-search__suggest-item_selected_yes {
      background-color: #ffeaf2;
      color: #ca4592;
    }

    .suggest-dropdown .ymaps-2-1-79-search__suggest-highlight {
      font-weight: 500;
    }

    .button {
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      font-weight: 500;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 16px;
      border: 2px solid #1a1c18;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      cursor: pointer;
      outline: none;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
    }

    .button--full-width {
      width: 100%;
    }

    .button--width-165 {
      min-width: 165px;
    }

    .button--purple {
      color: #ca4592;
      border-color: #ca4592;
    }

    @media (any-hover: hover) {
      .button--purple:hover {
        color: #ffffff;
        background-color: #ca4592;
      }
    }

    .button--green {
      color: #ffffff;
      background-color: #71be38;
      border-color: #71be38;
    }

    @media (any-hover: hover) {
      .button--green:hover {
        background-color: #58a122;
        border-color: #58a122;
      }
    }

    .button--pink {
      color: #ca4592;
      background-color: #ffeaf2;
      border-color: #ffeaf2;
    }

    @media (any-hover: hover) {
      .button--pink:hover {
        color: #ffffff;
        background-color: #ca4592;
        border-color: #ca4592;
      }
    }

    .button--red {
      color: #ba1a1a;
      border-color: #ba1a1a;
    }

    .button[disabled] {
      opacity: 0.7;
      pointer-events: none;
    }

    .add-product-to-cart-button {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 0;
      width: 52px;
      height: 52px;
      border-radius: 50%;
      border: 2px solid #71be38;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media (any-hover: hover) {
      .add-product-to-cart-button:hover {
        background-color: #71be38;
      }

      .add-product-to-cart-button:hover svg {
        fill: #ffffff;
      }
    }

    .add-product-to-cart-button svg {
      width: 16px;
      height: 16px;
      fill: #71be38;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .zoom-button {
      width: 42px;
      height: 42px;
    }

    .zoom-button svg {
      width: 42px;
      height: 42px;
    }

    .like-button .button__icon,
    .dislike-button .button__icon {
      width: 36px;
      height: 36px;
    }

    .link-button {
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #1098f7;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      cursor: pointer;
    }

    .link-button:hover {
      color: #71be38;
    }

    .link-button:hover .link-button__icon {
      fill: #71be38;
    }

    .link-button--center {
      margin-left: auto;
      margin-right: auto;
    }

    .link-button .link-button__icon {
      width: 16px;
      height: 16px;
      fill: #1098f7;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .remove-cart-item-button {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background-color: #ffdad6;
      border-radius: 12px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      -webkit-transition: background-color ease 0.3s;
      -o-transition: background-color ease 0.3s;
      transition: background-color ease 0.3s;
    }

    @media (any-hover: hover) {
      .remove-cart-item-button:hover {
        background-color: #ffb8b0;
      }
    }

    .remove-cart-item-button svg {
      width: 16px;
      height: 16px;
    }

    .add-cart-additional-item-button {
      width: 16px;
      height: 16px;
    }

    @media (any-hover: hover) {
      .add-cart-additional-item-button:hover svg {
        fill: #ca4592;
      }
    }

    .add-cart-additional-item-button.active {
      background-image: url(../img/image/check.svg);
    }

    .add-cart-additional-item-button svg {
      width: 16px;
      height: 16px;
      fill: #71be38;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .remove-cart-additional-item-button {
      width: 12px;
      height: 16px;
    }

    .remove-cart-additional-item-button svg {
      width: 12px;
      height: 16px;
    }

    .link {
      color: #ca4592;
    }

    @media (any-hover: hover) {
      .link:hover {
        color: #ae106c;
      }
    }

    .play-button {
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      width: 96px;
      height: 96px;
      z-index: 2;
    }

    .play-button.hidden {
      display: none;
    }

    @media screen and (max-width: 767px) {
      .play-button {
        width: 70px;
        height: 70px;
      }
    }

    @media (any-hover: hover) {
      .play-button:hover svg {
        fill: #fdf2f8;
      }
    }

    .play-button svg {
      width: 96px;
      height: 96px;
      fill: #fffefe;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 767px) {
      .play-button svg {
        width: 70px;
        height: 70px;
      }
    }

    .toggle-buttons__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    @media screen and (max-width: 575px) {
      .toggle-buttons__wrap {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .toggle-button {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      padding: 12px 20px;
      min-width: 180px;
      color: #ca4592;
      background-color: #ffeaf2;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      cursor: pointer;
    }

    .toggle-button:nth-child(1) {
      border-radius: 12px 0 0 12px;
    }

    @media screen and (max-width: 575px) {
      .toggle-button:nth-child(1) {
        border-radius: 12px 12px 0 0;
      }
    }

    .toggle-button:nth-child(2) {
      border-radius: 0 12px 12px 0;
    }

    @media screen and (max-width: 575px) {
      .toggle-button:nth-child(2) {
        border-radius: 0 0 12px 12px;
      }
    }

    .toggle-button.active {
      color: #fffefe;
      background-color: #ca4592;
    }

    @media (any-hover: hover) {
      .toggle-button:hover {
        color: #fffefe;
        background-color: #ca4592;
      }
    }

    .logo {
      display: block;
    }

    .logo img {
      width: 100%;
      height: auto;
      -o-object-fit: contain;
      object-fit: contain;
    }

    .nav__list {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    .nav__item {
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
    }

    .nav__link {
      font-size: 14px;
      font-weight: 500;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    @media (any-hover: hover) {
      .nav__link:hover {
        color: #ca4592;
      }
    }

    .header {
      position: relative;
      z-index: 5;
    }

    @media screen and (max-width: 1199px) {
      .header--search-active .header__row {
        position: relative;
      }
    }

    @media screen and (max-width: 767px) {

      .header--search-active .header__control--burger,
      .header--search-active .logo {
        display: none;
      }
    }

    .header .logo {
      width: 140px;
      height: 50px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      z-index: 1;
    }

    .header__row {
      max-width: 1240px;
      min-height: 80px;
      position: fixed;
      left: 50%;
      -webkit-transform: translateX(-50%);
      -ms-transform: translateX(-50%);
      transform: translateX(-50%);
      margin-top: 20px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 24px;
      padding: 14px 19px;
      background-color: #ffffff;
      border: 1px solid #dbe4e7;
      border-radius: 36px;
      z-index: 5;
    }

    @media screen and (max-width: 1279px) {
      .header__row {
        max-width: calc(100vw - 40px);
      }
    }

    @media screen and (max-width: 1199px) {
      .header__row {
        position: static;
        left: auto;
        -webkit-transform: none;
        -ms-transform: none;
        transform: none;
        margin-top: 10px;
        margin-left: 20px;
      }
    }

    @media screen and (max-width: 767px) {
      .header__row {
        max-width: calc(100vw - 20px);
        margin-left: 10px;
        gap: 10px;
      }
    }

    .header__menu {
      width: 100%;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    @media screen and (max-width: 1199px) {
      .header__menu.active {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    @media screen and (max-width: 1199px) {
      .header__menu {
        display: none;
        height: 100vh;
        height: calc(var(--vh, 1vh) * 100);
        padding: 25px 40px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #ffffff;
        z-index: 6;
      }
    }

    @media screen and (max-width: 767px) {
      .header__menu {
        padding-left: 30px;
        padding-right: 30px;
      }
    }

    .header__menu-heading {
      display: none;
      width: 100%;
    }

    @media screen and (max-width: 1199px) {
      .header__menu-heading {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }
    }

    .header__menu-content {
      width: 100%;
      height: 100%;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    @media screen and (max-width: 1199px) {
      .header__menu-content {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .header__menu-close {
      width: 42px;
      height: 42px;
      background-color: #dbe4e7;
      border-radius: 50%;
      position: relative;
      cursor: pointer;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .header__menu-close:before,
    .header__menu-close:after {
      position: absolute;
      content: "";
      top: 50%;
      left: 50%;
      width: 18px;
      height: 2px;
      border-radius: 1px;
      background-color: #6f797b;
      -webkit-transform: translate(-50%, -50%) rotate(45deg);
      -ms-transform: translate(-50%, -50%) rotate(45deg);
      transform: translate(-50%, -50%) rotate(45deg);
    }

    .header__menu-close:after {
      -webkit-transform: translate(-50%, -50%) rotate(-45deg);
      -ms-transform: translate(-50%, -50%) rotate(-45deg);
      transform: translate(-50%, -50%) rotate(-45deg);
    }

    .header__city {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 5px;
    }

    @media (any-hover: hover) {
      .header__city:hover .header__city-text {
        color: #ca4592;
        border-color: #ca4592;
      }
    }

    @media screen and (max-width: 1199px) {
      .header__city {
        margin-bottom: 30px;
        -webkit-box-ordinal-group: 3;
        -ms-flex-order: 2;
        order: 2;
      }
    }

    .header__city-icon {
      width: 16px;
      height: 16px;
    }

    .header__city-text {
      font-size: 12px;
      border-bottom: 1px dashed #1a1c18;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 1199px) {
      .header__city-text {
        font-size: 16px;
        font-weight: 300;
      }
    }

    .header__nav {
      margin-left: auto;
      margin-right: auto;
    }

    @media screen and (max-width: 1199px) {
      .header__nav {
        margin: auto;
        -webkit-box-ordinal-group: 2;
        -ms-flex-order: 1;
        order: 1;
      }
    }

    .header__nav .nav__list {
      gap: 15px;
    }

    @media screen and (max-width: 1199px) {
      .header__nav .nav__list {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        gap: 30px;
      }
    }

    @media screen and (max-width: 1199px) {
      .header__nav .nav__link {
        font-size: 18px;
        font-weight: 300;
      }
    }

    .header__phone {
      font-size: 14px;
      margin-left: auto;
    }

    @media screen and (max-width: 1199px) {
      .header__phone {
        font-size: 18px;
        font-weight: 300;
        margin-left: 0;
        margin-bottom: 30px;
        -webkit-box-ordinal-group: 4;
        -ms-flex-order: 3;
        order: 3;
      }
    }

    @media (any-hover: hover) {
      .header__phone:hover {
        color: #ca4592;
      }
    }

    .header__mobcontrols-wrap {
      display: none;
      width: calc(100% - 40px);
      padding: 12px 20px;
      position: fixed;
      bottom: 0;
      left: 50%;
      -webkit-transform: translateX(-50%);
      -ms-transform: translateX(-50%);
      transform: translateX(-50%);
      background-color: #fffefe;
      border: 1px solid #dbe4e7;
      border-radius: 36px 36px 0px 0px;
      z-index: 3;
    }

    @media screen and (max-width: 1199px) {
      .header__mobcontrols-wrap {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 12px;
      }
    }

    @media screen and (max-width: 767px) {
      .header__mobcontrols-wrap {
        width: calc(100% - 20px);
      }
    }

    .header__mobcontrol {
      width: 100%;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
    }

    .header__mobcontrol--mainpage .header__mobcontrol-icon {
      background-image: url(../img/image/flower.svg);
    }

    .header__mobcontrol--catalog .header__mobcontrol-icon {
      background-image: url(../img/image/bag.svg);
    }

    .header__mobcontrol--cart.active .header__mobcontrol-icon {
      display: none;
    }

    .header__mobcontrol--cart.active .header__mobcontrol-value {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 0;
    }

    .header__mobcontrol--cart .header__mobcontrol-icon {
      background-image: url(../img/image/cart-purple.svg);
    }

    .header__mobcontrol--cart .header__mobcontrol-value {
      display: none;
      min-width: 24px;
      height: 24px;
      padding: 2px;
      font-size: 10px;
      color: #ffffff;
      border-radius: 50%;
      background-color: #71be38;
    }

    .header__mobcontrol--personal .header__mobcontrol-icon {
      background-image: url(../img/image/profile.svg);
    }

    .header__mobcontrol-icon {
      width: 24px;
      height: 24px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 24px;
    }

    .header__mobcontrol-title {
      font-size: 10px;
      font-weight: 300;
    }

    .header__controls-wrap--mobile {
      display: none;
    }

    @media screen and (max-width: 1199px) {
      .header__controls-wrap--mobile {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        gap: 20px;
        -webkit-box-ordinal-group: 5;
        -ms-flex-order: 4;
        order: 4;
      }
    }

    .header__controls-wrap--mobile .header__control {
      width: 56px;
      height: 56px;
      background-size: 28px;
    }

    .header__controls-wrap--desktop {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 12px;
    }

    @media screen and (max-width: 1199px) {
      .header__controls-wrap--desktop {
        margin-left: auto;
      }
    }

    .header__search {
      display: none;
      width: 635px;
      position: absolute;
      top: 50%;
      right: 190px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }

    @media screen and (max-width: 1279px) {
      .header__search {
        width: 570px;
      }
    }

    @media screen and (max-width: 1199px) {
      .header__search {
        right: 127px;
      }
    }

    @media screen and (max-width: 991px) {
      .header__search {
        width: 460px;
      }
    }

    @media screen and (max-width: 767px) {
      .header__search {
        width: calc(100% - 94px);
        left: 20px;
        right: auto;
      }
    }

    .header__search.active {
      display: block;
    }

    .header__search .inputholder__input {
      padding-right: 35px;
    }

    .header__search .inputholder__input:focus+.reset-btn svg {
      fill: #1a1c18;
    }

    .header__search .reset-btn {
      position: absolute;
      top: 50%;
      right: 12px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
    }

    .header__search .reset-btn svg {
      width: 16px;
      height: 16px;
      fill: #bfc8cb;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .header__control {
      width: 42px;
      height: 42px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 0;
      border-radius: 50%;
      background-color: #fdf2f8;
      background-repeat: no-repeat;
      background-position: center;
      background-size: auto;
      -webkit-transition: background-color ease 0.3s;
      -o-transition: background-color ease 0.3s;
      transition: background-color ease 0.3s;
    }

    @media (any-hover: hover) {
      .header__control:hover {
        background-color: #ffeaf2;
      }
    }

    @media screen and (max-width: 1199px) {
      .header__control--desktop {
        display: none;
      }
    }

    .header__control--burger {
      display: none;
      background-image: url(../img/image/squares.svg);
      z-index: 1;
    }

    @media screen and (max-width: 1199px) {
      .header__control--burger {
        display: block;
      }
    }

    .header__control--burger.active {
      background-image: url(../img/image/cross-purple.svg);
    }

    .header__control--cart {
      background-image: url(../img/image/cart-purple.svg);
      position: relative;
    }

    .header__control--cart.active {
      background-image: url(../img/image/cart-green.svg);
      background-color: #d9f8c2;
    }

    @media (any-hover: hover) {
      .header__control--cart.active:hover {
        background-color: #b1f27e;
      }
    }

    .header__control--cart.active .header__control-value {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 0;
    }

    .header__control--cart .header__control-value {
      display: none;
      position: absolute;
      top: -9px;
      right: -9px;
      font-size: 13px;
      font-weight: 500;
      line-height: 1;
      color: #ffffff;
      width: 31px;
      height: 31px;
      background-color: #ca4592;
      border: 3px solid #ffffff;
      border-radius: 50%;
    }

    .header__control--search {
      background-image: url(../img/image/looking-glass-purple.svg);
    }

    .header__control--search.active {
      background-image: url(../img/image/cross-purple.svg);
    }

    .header__control--personal {
      background-image: url(../img/image/profile.svg);
    }

    .header__control-icon {
      width: 20px;
      height: 20px;
    }

    @media screen and (max-width: 1199px) {
      .heading {
        margin-top: 40px;
      }
    }

    .heading--small-banner .breadcrumbs__item,
    .heading--big-banner .breadcrumbs__item {
      color: #ffffff;
    }

    .heading--small-banner .breadcrumbs__item a,
    .heading--big-banner .breadcrumbs__item a {
      color: #bfc8cb;
    }

    @media (any-hover: hover) {

      .heading--small-banner .breadcrumbs__item a:hover,
      .heading--big-banner .breadcrumbs__item a:hover {
        color: #6f797b;
      }
    }

    .heading--small-banner .title-page h1,
    .heading--big-banner .title-page h1 {
      color: #ffffff;
    }

    .heading--small-banner .text-page,
    .heading--big-banner .text-page {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      max-width: 600px;
      color: #f8f7f7;
    }

    .heading--big-banner {
      min-height: 420px;
      margin: 0;
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      position: relative;
      border-radius: 0 0 30px 30px;
      overflow: hidden;
      z-index: 1;
    }

    @media screen and (max-width: 1199px) {
      .heading--big-banner {
        margin-top: -90px;
      }
    }

    .heading--big-banner::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: -1;
    }

    .heading--big-banner .title-page {
      max-width: 720px;
    }

    @media screen and (max-width: 1199px) {
      .heading--small-banner {
        margin-top: 20px;
      }
    }

    .heading--small-banner .heading__row {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      min-height: 260px;
      padding: 50px 40px;
      border-radius: 24px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .heading--small-banner .heading__row::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: -1;
    }

    @media screen and (max-width: 767px) {
      .heading--small-banner .heading__row {
        padding: 30px;
        min-height: 340px;
      }
    }

    .heading__row {
      padding: 0 20px;
    }

    .title-page h1 {
      word-break: break-word;
    }

    .text-page {
      font-size: 18px;
      font-weight: 300;
      line-height: 1.25;
      color: #6f797b;
      margin-top: 20px;
    }

    .content {
      max-width: 910px;
      padding: 0 20px;
    }

    .content h2:not(:first-child),
    .content .h2:not(:first-child),
    .content h3:not(:first-child),
    .content .h3:not(:first-child),
    .content figure:not(:first-child),
    .content blockquote:not(:first-child) {
      margin-top: 40px;
    }

    @media screen and (max-width: 767px) {

      .content h2:not(:first-child),
      .content .h2:not(:first-child),
      .content h3:not(:first-child),
      .content .h3:not(:first-child),
      .content figure:not(:first-child),
      .content blockquote:not(:first-child) {
        margin-top: 30px;
      }
    }

    .content h2:not(:last-child),
    .content .h2:not(:last-child),
    .content h3:not(:last-child),
    .content .h3:not(:last-child),
    .content figure:not(:last-child),
    .content blockquote:not(:last-child) {
      margin-bottom: 40px;
    }

    @media screen and (max-width: 767px) {

      .content h2:not(:last-child),
      .content .h2:not(:last-child),
      .content h3:not(:last-child),
      .content .h3:not(:last-child),
      .content figure:not(:last-child),
      .content blockquote:not(:last-child) {
        margin-bottom: 30px;
      }
    }

    .content h2,
    .content .h2,
    .content h3,
    .content .h3 {
      padding-left: 0;
      padding-right: 0;
    }

    .content p,
    .content span,
    .content ol li,
    .content ul li {
      font-size: 18px;
      font-weight: 300;
      line-height: 1.25;
    }

    .content p:first-child {
      margin-top: 0;
    }

    .content p:last-child {
      margin-bottom: 0;
    }

    .content p:not(:first-child) {
      margin-top: 30px;
    }

    .content ol,
    .content ul {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
    }

    .content ol:not(:first-child),
    .content ul:not(:first-child) {
      margin-top: 20px;
    }

    .content ol:not(:last-child),
    .content ul:not(:last-child) {
      margin-bottom: 20px;
    }

    .content ol {
      counter-reset: numList;
    }

    .content ol li {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 8px;
    }

    .content ol li::before {
      content: counter(numList) ".";
      counter-increment: numList;
      display: block;
      font-size: 18px;
      color: #ca4592;
    }

    .content ul li {
      padding-left: 18px;
      position: relative;
    }

    .content ul li::before {
      content: "";
      position: absolute;
      top: 6px;
      left: 0;
      width: 6px;
      height: 6px;
      background-color: #ca4592;
      border-radius: 1px;
    }

    .content blockquote {
      font-size: 18px;
      padding: 20px 0 20px 19px;
      border-left: 4px solid #ca4592;
    }

    .content figure img,
    .content>img {
      border-radius: 12px;
    }

    .content figcaption {
      font-size: 14px;
      font-weight: 300;
      text-align: center;
      color: #6f797b;
      max-width: 640px;
      margin: 14px auto 0;
    }

    .content table {
      border-radius: 12px;
      overflow: hidden;
    }

    @media screen and (max-width: 767px) {
      .content table {
        display: block;
        overflow: auto;
      }
    }

    .content table:not(:first-child) {
      margin-top: 30px;
    }

    .content table:not(:last-child) {
      margin-bottom: 30px;
    }

    .content table thead td {
      font-size: 18px;
      color: #6f797b;
      background-color: #eff1f2;
    }

    .content table tbody tr:nth-child(odd) td {
      background-color: #ffffff;
    }

    .content table tbody tr:nth-child(even) td {
      background-color: #eff1f2;
    }

    .content table tbody td {
      font-weight: 300;
    }

    .content table td {
      text-align: center;
      padding: 25px 23px;
    }

    .content a {
      color: #ca4592;
    }

    @media (any-hover: hover) {
      .content a:hover {
        color: #ae106c;
      }
    }

    .swiper-button-prev,
    .swiper-button-next {
      top: 50%;
      width: 36px;
      height: 36px;
      margin: 0;
      z-index: 2;
    }

    .swiper-button-prev::before,
    .swiper-button-prev::after,
    .swiper-button-next::before,
    .swiper-button-next::after {
      display: none;
    }

    .swiper-button-prev--white svg,
    .swiper-button-next--white svg {
      fill: #fffefe;
    }

    .swiper-button-prev svg,
    .swiper-button-next svg {
      width: 36px;
      height: 36px;
    }

    .swiper-button-prev {
      -webkit-transform: translateY(-50%) rotate(180deg);
      -ms-transform: translateY(-50%) rotate(180deg);
      transform: translateY(-50%) rotate(180deg);
    }

    .swiper-button-next {
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }

    .slider {
      position: relative;
    }

    .slider--banner {
      border-radius: 0 0 30px 30px;
      position: relative;
      overflow: hidden;
    }

    .slider--banner .swiper-slide {
      height: auto;
    }

    .slider--banner .swiper-pagination {
      bottom: 60px;
    }

    @media screen and (max-width: 991px) {
      .slider--banner .swiper-pagination {
        bottom: 70px;
      }
    }

    .slider--banner .swiper__navigation {
      width: 100%;
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      z-index: 1;
      pointer-events: none;
    }

    @media screen and (max-width: 767px) {
      .slider--banner .swiper__navigation {
        display: none;
      }
    }

    .slider--banner .swiper__navigation .swiper-button-prev,
    .slider--banner .swiper__navigation .swiper-button-next {
      pointer-events: all;
    }

    .slider--banner .banner__item {
      height: 100%;
    }

    @media screen and (max-width: 575px) {
      .slider--products .swiper {
        width: calc(100% + 10px);
      }
    }

    .slider--products .swiper-slide {
      height: auto;
    }

    @media screen and (max-width: 575px) {
      .slider--products .swiper-slide {
        max-width: 260px;
      }
    }

    .slider--products .swiper-slide .product {
      height: 100%;
    }

    .slider--products .swiper-button-prev {
      left: -50px;
    }

    @media screen and (max-width: 1379px) {
      .slider--products .swiper-button-prev {
        left: -20px;
      }
    }

    @media screen and (max-width: 575px) {
      .slider--products .swiper-button-prev {
        display: none;
      }
    }

    .slider--products .swiper-button-next {
      right: -50px;
    }

    @media screen and (max-width: 1379px) {
      .slider--products .swiper-button-next {
        right: -20px;
      }
    }

    @media screen and (max-width: 575px) {
      .slider--products .swiper-button-next {
        display: none;
      }
    }

    .slider--product-detail {
      width: 100%;
      max-width: 500px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      position: relative;
    }

    @media screen and (max-width: 991px) {
      .slider--product-detail {
        margin: 0 auto;
      }
    }

    .slider--product-detail .swiper {
      border-radius: 36px;
      overflow: hidden;
    }

    .slider--product-detail .swiper-slide--video {
      position: relative;
    }

    .slider--product-detail .swiper-slide--video::before {
      content: "";
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      background: rgba(0, 0, 0, 0.3);
    }

    .slider--product-detail .swiper-pagination {
      bottom: -24px;
    }

    .slider--product-detail .swiper-button-prev {
      left: 10px;
    }

    .slider--product-detail .swiper-button-next {
      right: 10px;
    }

    .slider--product-detail .zoom-button {
      position: absolute;
      bottom: 20px;
      right: 20px;
    }

    .swiper-pagination {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      z-index: 2;
    }

    .swiper-pagination--darkgrey .swiper-pagination-bullet {
      background-color: #bfc8cb;
    }

    .swiper-pagination--lightgrey .swiper-pagination-bullet {
      background-color: #f8f7f7;
    }

    .swiper-pagination--darkgrey .swiper-pagination-bullet-active,
    .swiper-pagination--lightgrey .swiper-pagination-bullet-active {
      background-color: #71be38;
      opacity: 1;
    }

    .swiper-pagination-bullet {
      opacity: 0.5;
    }

    .overlay {
      position: fixed;
      z-index: 10;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: none;
      background: #000000;
    }

    .modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      max-width: 520px;
      width: 100%;
      max-height: 90vh;
      padding: 20px 24px;
      background-color: #ffffff;
      border-radius: 12px;
      z-index: 11;
      overflow-y: auto;
      overflow-x: hidden;
    }

    @media screen and (max-width: 575px) {
      .modal {
        max-width: calc(100vw - 20px);
      }
    }

    .modal[data-modal=catalog] {
      max-width: 100%;
      max-height: 100vh;
      height: 100vh;
      height: calc(var(--vh, 1vh) * 100);
      padding-left: 10px;
      padding-right: 10px;
      border-radius: 0;
      overflow: hidden;
    }

    @media (any-hover: hover) {
      .modal[data-modal=catalog] a:hover {
        color: #ca4592;
      }
    }

    .modal[data-modal=catalog] .modal__title {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    @media screen and (max-width: 767px) {
      .modal[data-modal=catalog] .modal__title {
        font-size: 24px;
      }
    }

    .modal[data-modal=catalog] .modal__heading {
      padding-bottom: 20px;
      margin-bottom: 25px;
      border-bottom: 1px solid #dbe4e7;
    }

    @media screen and (max-width: 767px) {
      .modal[data-modal=catalog] .modal__heading {
        margin-bottom: 20px;
      }
    }

    .modal[data-modal=catalog] .modal__container {
      width: calc(100% + 20px);
      max-height: calc(100vh - 132px);
      padding-right: 20px;
      overflow: auto;
    }

    .modal[data-modal=catalog] .modal__category {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: start;
      -ms-flex-align: start;
      align-items: flex-start;
    }

    .modal[data-modal=catalog] .modal__category:not(:first-child) {
      padding-top: 25px;
      border-top: 1px solid #dbe4e7;
    }

    .modal[data-modal=catalog] .modal__category:not(:last-child) {
      padding-bottom: 25px;
    }

    .modal[data-modal=catalog] .modal__category-heading {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      width: 100%;
      max-width: 220px;
      margin-right: 30px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-heading {
        max-width: 100%;
        margin-right: 0;
      }
    }

    .modal[data-modal=catalog] .modal__category-title {
      font-size: 20px;
      font-weight: 400;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .modal[data-modal=catalog] .arrow {
      display: none;
      width: 24px;
      height: 24px;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .arrow {
        display: block;
      }
    }

    .modal[data-modal=catalog] .modal__category-return {
      display: none;
      cursor: pointer;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-return {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        gap: 16px;
      }
    }

    .modal[data-modal=catalog] .arrow-return {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background-color: #ffeaf2;
    }

    .modal[data-modal=catalog] .arrow-return svg {
      width: 12px;
      height: 12px;
    }

    .modal[data-modal=catalog] .modal__category-return__title {
      font-size: 24px;
      font-weight: 600;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      font-stretch: 120%;
    }

    .modal[data-modal=catalog] .modal__category-list__wrap {
      width: 100%;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list__wrap {
        width: 100%;
        height: 100vh;
        height: calc(var(--vh, 1vh) * 100);
        padding: 20px;
        position: fixed;
        top: 0;
        left: 100%;
        background-color: #ffffff;
        -webkit-transition: 0.3s ease;
        -o-transition: 0.3s ease;
        transition: 0.3s ease;
      }
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list__wrap.active {
        -webkit-transform: translateX(-100%);
        -ms-transform: translateX(-100%);
        transform: translateX(-100%);
        z-index: 3;
      }
    }

    .modal[data-modal=catalog] .modal__category-list__heading {
      display: none;
      padding-bottom: 20px;
      border-bottom: 1px solid #dbe4e7;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list__heading {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }
    }

    .modal[data-modal=catalog] .modal__category-list {
      width: 100%;
      -webkit-column-count: 4;
      -moz-column-count: 4;
      column-count: 4;
      margin-bottom: -15px;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-column-count: 1;
        -moz-column-count: 1;
        column-count: 1;
        max-height: calc(100vh - 98px);
        padding-top: 20px;
        margin-bottom: 0;
        overflow: auto;
      }
    }

    .modal[data-modal=catalog] .modal__category-list__item {
      display: inline-block;
      width: 100%;
      margin-bottom: 15px;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list__item:last-child {
        margin-bottom: 0;
      }
    }

    .modal[data-modal=catalog] .modal__category-list__link {
      color: #6f797b;
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=catalog] .modal__category-list__link {
        font-size: 18px;
        font-weight: 300;
      }
    }

    .modal[data-modal=cart-region] .modal__container,
    .modal[data-modal=city-confirm] .modal__container,
    .modal[data-modal=delivery-area] .modal__container,
    .modal[data-modal=invoice-payment] .modal__container,
    .modal[data-modal=rate-checkout] .modal__container,
    .modal[data-modal=rate-checkout-thanks] .modal__container {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=cart-region] .form__buttonholder,
    .modal[data-modal=cart-region] .buttons__wrap,
    .modal[data-modal=city-confirm] .form__buttonholder,
    .modal[data-modal=city-confirm] .buttons__wrap,
    .modal[data-modal=delivery-area] .form__buttonholder,
    .modal[data-modal=delivery-area] .buttons__wrap,
    .modal[data-modal=rate-checkout] .form__buttonholder,
    .modal[data-modal=rate-checkout] .buttons__wrap,
    .modal[data-modal=rate-checkout-thanks] .form__buttonholder,
    .modal[data-modal=rate-checkout-thanks] .buttons__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
    }

    .modal[data-modal=cart-region] .modal__text,
    .modal[data-modal=delivery-area] .modal__text,
    .modal[data-modal=leave-review] .modal__text,
    .modal[data-modal=password-recovery-new] .modal__text,
    .modal[data-modal=personal-confirm-changes] .modal__text,
    .modal[data-modal=rate-checkout] .modal__text,
    .modal[data-modal=rate-checkout-thanks] .modal__text,
    .modal[data-modal=registration-confirm] .modal__text,
    .modal[data-modal=personal-confirm-changes] .modal__text {
      color: #6f797b;
    }

    .modal[data-modal=rate-checkout] .form {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=rate-checkout] .modal__heading {
      margin-bottom: 0;
    }

    @media screen and (max-width: 575px) {

      .modal[data-modal=cart-region] .buttons__wrap,
      .modal[data-modal=city-confirm] .buttons__wrap,
      .modal[data-modal=delivery-area] .buttons__wrap {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .modal[data-modal=city-confirm] .modal__city {
      font-weight: 500;
      color: #ca4592;
    }

    .modal[data-modal=city] {
      max-width: 890px;
      height: 469px;
      overflow: auto;
    }

    .modal[data-modal=city] .modal__container {
      max-height: 100%;
      overflow: hidden;
    }

    .modal[data-modal=city] .inputholder__input {
      padding-right: 35px;
    }

    .modal[data-modal=city] .inputholder__input:focus+.reset-btn svg {
      fill: #1a1c18;
    }

    .modal[data-modal=city] .reset-btn {
      position: absolute;
      top: 50%;
      right: 12px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
    }

    .modal[data-modal=city] .reset-btn svg {
      width: 16px;
      height: 16px;
      fill: #bfc8cb;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .modal[data-modal=city] .modal__city-search {
      position: relative;
    }

    .modal[data-modal=city] .modal__city-dropdown {
      width: 100%;
      height: 0;
      position: absolute;
      top: calc(100% + 3px);
      left: 0;
      background-color: #ffffff;
      opacity: 0.8;
      overflow: hidden;
    }

    .modal[data-modal=city] .modal__city-dropdown__content {
      height: calc(90vh - 100px);
      overflow: auto;
    }

    .modal[data-modal=city] .modal__cities-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 15px 26px;
      max-height: calc(90vh - 100px);
      padding: 0 20px 10px;
      margin-top: 30px;
      overflow: auto;
    }

    @media screen and (max-width: 767px) {
      .modal[data-modal=city] .modal__cities-list {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media screen and (max-width: 575px) {
      .modal[data-modal=city] .modal__cities-list {
        grid-template-columns: repeat(1, 1fr);
      }
    }

    .modal[data-modal=city] .modal__cities-list__item {
      color: #6f797b;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      cursor: pointer;
    }

    @media (any-hover: hover) {
      .modal[data-modal=city] .modal__cities-list__item:hover {
        color: #ca4592;
      }
    }

    .modal[data-modal=invoice-payment] .form {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=invoice-payment] .form__buttonholder {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 10px;
    }

    @media screen and (max-width: 575px) {
      .modal[data-modal=invoice-payment] .form__buttonholder {
        grid-template-columns: auto;
      }
    }

    .modal[data-modal=invoice-payment] .buttonholder {
      width: 100%;
    }

    @media screen and (max-width: 575px) {
      .modal[data-modal=invoice-payment] .buttonholder {
        -webkit-box-ordinal-group: 0;
        -ms-flex-order: -1;
        order: -1;
      }
    }

    .modal[data-modal=login],
    .modal[data-modal=registration],
    .modal[data-modal=password-recovery],
    .modal[data-modal=password-recovery-new],
    .modal[data-modal=password-recovery-request],
    .modal[data-modal=personal-confirm-changes],
    .modal[data-modal=registration-confirm] {
      max-width: 380px;
    }

    .modal[data-modal=login] .form__buttonholder,
    .modal[data-modal=registration] .form__buttonholder,
    .modal[data-modal=password-recovery] .form__buttonholder,
    .modal[data-modal=password-recovery-new] .form__buttonholder,
    .modal[data-modal=password-recovery-request] .form__buttonholder,
    .modal[data-modal=personal-confirm-changes] .form__buttonholder,
    .modal[data-modal=registration-confirm] .form__buttonholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
      margin-top: 30px;
    }

    .modal[data-modal=login] .form__policy,
    .modal[data-modal=registration] .form__policy,
    .modal[data-modal=password-recovery] .form__policy,
    .modal[data-modal=password-recovery-new] .form__policy,
    .modal[data-modal=password-recovery-request] .form__policy,
    .modal[data-modal=personal-confirm-changes] .form__policy,
    .modal[data-modal=registration-confirm] .form__policy {
      margin-top: 15px;
    }

    .modal[data-modal=leave-review] .form__buttonholder {
      margin-top: 30px;
    }

    .modal[data-modal=notification-added-to-cart] {
      max-width: 360px;
      top: auto;
      left: auto;
      bottom: 20px;
      right: 20px;
      -webkit-transform: none;
      -ms-transform: none;
      transform: none;
      -webkit-box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
    }

    @media screen and (max-width: 1199px) {
      .modal[data-modal=notification-added-to-cart] {
        bottom: 82px;
      }
    }

    @media screen and (max-width: 767px) {
      .modal[data-modal=notification-added-to-cart] {
        right: 10px;
      }
    }

    @media screen and (max-width: 767px) {
      .modal[data-modal=notification-added-to-cart] {
        max-width: calc(100vw - 20px);
      }
    }

    .modal[data-modal=notification-added-to-cart] .modal__container {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 16px;
    }

    .modal[data-modal=notification-added-to-cart] .modal__image-wrap {
      width: 42px;
      height: 42px;
      border-radius: 8px;
      overflow: hidden;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .modal[data-modal=notification-added-to-cart] .modal__image {
      width: 100%;
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
    }

    .modal[data-modal=notification-added-to-cart] .modal__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 4px;
    }

    .modal[data-modal=notification-added-to-cart] .modal__title {
      font-size: 16px;
      font-weight: 500;
      line-height: 1.25;
      color: #ca4592;
    }

    .modal[data-modal=notification-added-to-cart] .modal__text {
      font-size: 14px;
    }

    .modal[data-modal=leave-review] {
      max-width: 520px;
    }

    .modal[data-modal=leave-review] .inputholder__textarea {
      min-height: 160px;
    }

    .modal[data-modal=leave-review] .form__buttonholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
    }

    @media screen and (max-width: 575px) {
      .modal[data-modal=leave-review] .form__buttonholder {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 15px;
      }
    }

    .modal[data-modal=leave-review] .form__policy {
      max-width: 270px;
      text-align: left;
      -webkit-box-ordinal-group: 0;
      -ms-flex-order: -1;
      order: -1;
    }

    @media screen and (max-width: 575px) {
      .modal[data-modal=leave-review] .form__policy {
        text-align: center;
        -webkit-box-ordinal-group: 2;
        -ms-flex-order: 1;
        order: 1;
      }
    }

    @media screen and (max-width: 575px) {

      .modal[data-modal=leave-review] .buttonholder,
      .modal[data-modal=leave-review] .submit-button {
        width: 100%;
      }
    }

    .modal[data-modal=registration] .checkbox {
      margin-top: 10px;
    }

    .modal[data-modal=personal-confirm-changes] .modal__container,
    .modal[data-modal=registration-confirm] .modal__container {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=personal-confirm-changes] .form {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=personal-confirm-changes] .modal__heading {
      margin-bottom: 0;
    }

    .modal[data-modal=personal-confirm-changes] .form__buttonholder {
      margin-top: 0;
    }

    .modal[data-modal=registration-confirm] .form .modal__text {
      margin-bottom: 30px;
    }

    .modal[data-modal=change-composition],
    .modal[data-modal=change-composition-mono] {
      max-width: 358px;
    }

    .modal[data-modal=change-composition] .modal__container,
    .modal[data-modal=change-composition-mono] .modal__container {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal[data-modal=change-composition] .fields,
    .modal[data-modal=change-composition-mono] .fields {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 15px;
    }

    .modal[data-modal=change-composition] .modal__total,
    .modal[data-modal=change-composition-mono] .modal__total {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -webkit-box-align: end;
      -ms-flex-align: end;
      align-items: flex-end;
      gap: 16px;
    }

    .modal[data-modal=change-composition] .modal__total-title,
    .modal[data-modal=change-composition-mono] .modal__total-title {
      font-size: 22px;
      font-weight: 400;
      line-height: 1.18;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .modal[data-modal=change-composition] .modal__total-price__wrap,
    .modal[data-modal=change-composition-mono] .modal__total-price__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: baseline;
      -ms-flex-align: baseline;
      align-items: baseline;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 5px 12px;
    }

    .modal[data-modal=change-composition] .modal__total-price,
    .modal[data-modal=change-composition-mono] .modal__total-price {
      margin-left: auto;
    }

    .modal[data-modal=change-composition] .modal__total-price:not(.modal__total-price--old),
    .modal[data-modal=change-composition-mono] .modal__total-price:not(.modal__total-price--old) {
      font-weight: 600;
      font-size: 36px;
      line-height: 1;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      font-stretch: 120%;
    }

    .modal[data-modal=change-composition] .modal__total-price--old,
    .modal[data-modal=change-composition-mono] .modal__total-price--old {
      line-height: 1.18;
      font-weight: 300;
      color: #6f797b;
      -webkit-text-decoration-line: line-through;
      text-decoration-line: line-through;
    }

    .modal .login-button {
      margin-top: 15px;
    }

    .modal .repeat-code {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 5px;
      width: 100%;
      padding: 12px 0;
      color: #ca4592;
    }

    .modal .form__policy {
      text-align: center;
    }

    .modal__heading {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 30px;
    }

    .modal__close {
      width: 42px;
      height: 42px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      background-color: #dbe4e7;
      position: relative;
      border-radius: 50%;
      cursor: pointer;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media (any-hover: hover) {
      .modal__close:hover {
        background-color: #fdf2f8;
      }

      .modal__close:hover::before,
      .modal__close:hover::after {
        background-color: #ca4592;
      }
    }

    .modal__close:before,
    .modal__close:after {
      position: absolute;
      content: "";
      top: 50%;
      left: 50%;
      width: 18px;
      height: 2px;
      border-radius: 1px;
      background-color: #6f797b;
      -webkit-transform: translate(-50%, -50%) rotate(45deg);
      -ms-transform: translate(-50%, -50%) rotate(45deg);
      transform: translate(-50%, -50%) rotate(45deg);
    }

    .modal__close:after {
      -webkit-transform: translate(-50%, -50%) rotate(-45deg);
      -ms-transform: translate(-50%, -50%) rotate(-45deg);
      transform: translate(-50%, -50%) rotate(-45deg);
    }

    .modal__title {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
    }

    .modal__text {
      font-weight: 300;
    }

    .modal__thanks {
      display: none;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .modal__thanks .modal__heading {
      margin-bottom: 0;
    }

    @media screen and (max-width: 767px) {
      .footer>.container {
        padding: 0;
      }
    }

    .footer .logo {
      width: 151px;
      height: 54px;
    }

    @media screen and (max-width: 767px) {
      .footer .logo {
        margin-bottom: 26px;
      }
    }

    .footer__top,
    .footer__bottom {
      background-color: #ffffff;
    }

    .footer__top {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 26px;
      padding: 24px 30px 0 30px;
      border-radius: 30px 30px 0 0;
    }

    @media screen and (max-width: 1199px) {
      .footer__top {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__top {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        gap: 0;
      }
    }

    .footer__phone {
      font-size: 14px;
      font-weight: 500;
    }

    @media (any-hover: hover) {
      .footer__phone:hover {
        color: #ca4592;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__phone {
        font-size: 18px;
        font-weight: 300;
        margin-bottom: 60px;
      }
    }

    .footer__social {
      gap: 10px;
    }

    @media screen and (max-width: 767px) {
      .footer__social {
        gap: 16px;
        margin-bottom: 26px;
      }
    }

    .footer__social .social__item {
      width: 38px;
      height: 38px;
      background-color: #fdf2f8;
      border-radius: 50%;
    }

    @media (any-hover: hover) {
      .footer__social .social__item:hover {
        background-color: #ffeaf2;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__social .social__item {
        width: 48px;
        height: 48px;
        background-color: #f8f7f7;
      }
    }

    .footer__social .social__icon {
      width: 24px;
      height: 24px;
    }

    @media screen and (max-width: 767px) {
      .footer__social .social__icon {
        width: 31px;
        height: 31px;
      }
    }

    .footer__nav {
      margin-left: auto;
    }

    @media screen and (max-width: 1199px) {
      .footer__nav {
        margin-right: auto;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__nav {
        margin-left: 0;
        margin-bottom: 40px;
      }
    }

    .footer__nav .nav__list {
      gap: 30px;
    }

    @media screen and (max-width: 1279px) {
      .footer__nav .nav__list {
        gap: 16px;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__nav .nav__list {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__nav .nav__link {
        font-size: 18px;
        font-weight: 300;
      }
    }

    .footer__bottom {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 16px;
      padding: 20px 30px 24px 30px;
    }

    @media screen and (max-width: 1199px) {
      .footer__bottom {
        padding-bottom: 100px;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__bottom {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        gap: 0;
      }
    }

    .footer__info {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 16px;
    }

    @media screen and (max-width: 767px) {
      .footer__info {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        gap: 0;
        margin-bottom: 40px;
      }
    }

    .footer__copyright {
      font-size: 12px;
      font-weight: 500;
    }

    @media screen and (max-width: 767px) {
      .footer__copyright {
        font-size: 16px;
        font-weight: 300;
        margin-bottom: 24px;
      }
    }

    .footer__address {
      font-size: 12px;
      font-weight: 500;
      color: #6f797b;
    }

    @media screen and (max-width: 767px) {
      .footer__address {
        font-size: 16px;
        font-weight: 300;
      }
    }

    .footer__texterra {
      font-weight: 300;
      font-size: 14px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: end;
      -ms-flex-align: end;
      align-items: flex-end;
      gap: 10px;
    }

    @media screen and (max-width: 767px) {
      .footer__texterra {
        font-size: 16px;
        margin-bottom: 40px;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__texterra-text {
        padding-bottom: 2px;
      }
    }

    .footer__texterra-link {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    @media (any-hover: hover) {
      .footer__texterra-link:hover .footer__texterra-icon {
        fill: #c02b23;
      }
    }

    .footer__texterra-icon {
      width: 90px;
      height: 21px;
      fill: #2e3a4c;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 767px) {
      .footer__texterra-icon {
        width: 140px;
        height: 33px;
      }
    }

    .footer__links-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 16px;
    }

    @media screen and (max-width: 767px) {
      .footer__links-wrap {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
      }
    }

    .footer__link {
      font-size: 12px;
      font-weight: 500;
      color: #6f797b;
    }

    @media (any-hover: hover) {
      .footer__link:hover {
        color: #ca4592;
      }
    }

    @media screen and (max-width: 767px) {
      .footer__link {
        font-size: 16px;
        font-weight: 300;
      }
    }

    .policy__link {
      color: #ca4592;
    }

    .notification {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      margin-top: 20px;
      border-radius: 12px;
    }

    .notification--info {
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 20px 30px;
      padding: 20px 30px;
      background-color: #fee7cc;
    }

    @media screen and (max-width: 575px) {
      .notification--info {
        padding: 20px;
      }
    }

    .notification--info .notification__icon {
      fill: #fb8500;
    }

    .notification--info .notification__text {
      color: #fb8500;
    }

    .notification--info .notification-button .button__title {
      color: #fb8500;
    }

    .notification--info .notification-button .button__icon {
      fill: #fb8500;
    }

    .notification--error {
      padding: 18px 30px;
      background-color: #ffdad6;
    }

    .notification--error .notification__icon {
      fill: #ba1a1a;
    }

    .notification--error .notification__text {
      color: #ba1a1a;
    }

    .notification__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 15px;
    }

    .notification__icon {
      width: 22px;
      height: 22px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .notification__text {
      font-size: 14px;
      font-weight: 300;
    }

    .notification-button {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
      margin-left: auto;
      cursor: pointer;
    }

    .notification-button .button__title {
      font-size: 14px;
    }

    .notification-button .button__icon {
      width: 16px;
      height: 16px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .select {
      position: relative;
      color: #1a1c18;
    }

    .select__active {
      width: 100%;
      padding: 11px 30px 11px 10px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 12px;
      background-color: #ffffff;
      border: 2px solid #dbe4e7;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      position: relative;
      cursor: pointer;
    }

    .select__active:before {
      content: "";
      position: absolute;
      width: 22px;
      height: 22px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 10px;
      background-image: url(../img/image/arrow-select.svg);
      top: 50%;
      right: 7px;
      -webkit-transform: translate(0, -50%);
      -ms-transform: translate(0, -50%);
      transform: translate(0, -50%);
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .select__active.open:before {
      -webkit-transform: translate(0, -50%) rotate(180deg);
      -ms-transform: translate(0, -50%) rotate(180deg);
      transform: translate(0, -50%) rotate(180deg);
    }

    .select__text {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      overflow: hidden;
      -webkit-box-orient: vertical;
    }

    .select__drop {
      display: none;
      position: absolute;
      top: calc(100% + 10px);
      z-index: 1;
      width: 100%;
      padding: 6px;
      font-size: 14px;
      font-weight: 400;
      border-radius: 12px;
      background-color: #fffefe;
      -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08);
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08);
    }

    .select__item {
      display: block;
      padding: 8px;
      color: #1a1c18;
      border-radius: 12px;
      cursor: pointer;
    }

    .select__item.active {
      color: #ca4592;
      background-color: #ffeaf2;
    }

    .select__input {
      display: none;
    }

    .dropdown {
      position: absolute;
      top: calc(100% + 8px);
      left: 0;
      height: 0;
      background-color: #fffefe;
      -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08);
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.08);
      border-radius: 12px;
      overflow: hidden;
      z-index: 3;
    }

    .dropdown.active {
      display: block;
    }

    .dropdown__list {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      max-height: 184px;
      padding: 8px;
      gap: 4px;
      overflow: auto;
    }

    .dropdown__list-link {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      padding: 14px 15px;
      border-radius: 12px;
    }

    @media screen and (max-width: 767px) {
      .dropdown__list-link {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        gap: 5px;
      }
    }

    @media screen and (max-width: 575px) {
      .dropdown__list-link {
        padding: 5px;
      }
    }

    @media (any-hover: hover) {
      .dropdown__list-link:hover {
        color: #ffffff;
        background-color: #ffeaf2;
      }

      .dropdown__list-link:hover .dropdown__list-link__title,
      .dropdown__list-link:hover .dropdown__list-link__price {
        color: #ca4592;
      }
    }

    .dropdown__list-link__title,
    .dropdown__list-link__price {
      font-size: 14px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .dropdown__list-link__title {
      width: calc(100% - 70px);
    }

    @media screen and (max-width: 767px) {
      .dropdown__list-link__title {
        width: 100%;
      }
    }

    .social {
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    .social__item {
      width: 38px;
      height: 38px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .social__icon {
      width: 24px;
      height: 24px;
      fill: #ca4592;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 767px) {
      .social__icon {
        width: 31px;
        height: 31px;
      }
    }

    .section.banner {
      width: 100%;
      max-width: 1920px;
      margin: 0 auto;
    }

    @media screen and (max-width: 1199px) {
      .section.banner {
        margin-top: -90px;
      }
    }

    .banner__item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: start;
      -ms-flex-align: start;
      align-items: flex-start;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      min-height: 540px;
      padding-top: 193px;
      padding-bottom: 80px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      position: relative;
    }

    @media screen and (max-width: 767px) {
      .banner__item {
        padding-top: 160px;
      }
    }

    .banner__item::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 2;
    }

    .banner__item>.container {
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
    }

    .banner__item-content {
      width: 100%;
      max-width: 640px;
      position: relative;
      z-index: 2;
    }

    .banner__item-title,
    .banner__item-text {
      text-align: center;
    }

    .banner__item-title {
      display: block;
      font-size: 48px;
      font-weight: 600;
      line-height: 1.16;
      color: #fffefe;
      font-stretch: 120%;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      word-break: break-word;
    }

    @media screen and (max-width: 991px) {
      .banner__item-title {
        font-size: 36px;
      }
    }

    .banner__item-text {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
      color: #f8f7f7;
      font-stretch: 150%;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      margin-top: 20px;
    }

    .products__wrap {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 30px 24px;
    }

    @media screen and (max-width: 1199px) {
      .products__wrap {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media screen and (max-width: 767px) {
      .products__wrap {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media screen and (max-width: 480px) {
      .products__wrap {
        grid-template-columns: repeat(1, 1fr);
      }
    }

    .products__wrap>.show-more-button,
    .products__wrap>.return-to-mainpage-button {
      grid-column: 1/-1;
      margin: 0 auto;
    }

    .product {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      padding: 16px 20px;
      background-color: #fffefe;
      border-radius: 24px;
    }

    .product__label {
      position: absolute;
      top: 12px;
      left: 12px;
      padding: 4px 12px;
      background-color: #71be38;
      border-radius: 50px;
      font-weight: 300;
      font-size: 14px;
      line-height: 1.25;
      color: #ffffff;
    }

    .product__composition {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 5px;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      padding: 16px 20px;
      background-color: #f8f7f7;
      z-index: 2;
      opacity: 0;
      visibility: hidden;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .product-composition__list-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 5px;
    }

    .product-composition__item-title,
    .product-composition__item-quantity {
      font-weight: 300;
      font-size: 14px;
      line-height: 1.25;
    }

    .product-composition__item-quantity {
      color: #aaaaaa;
    }

    .product__image-wrap {
      display: block;
      position: relative;
      height: 0;
      padding-bottom: 94.4444444444%;
      border-radius: 20px;
      overflow: hidden;
    }

    @media (any-hover: hover) {
      .product__image-wrap:hover .product__composition {
        opacity: 1;
        visibility: visible;
      }
    }

    .product__image-wrap:not(:last-child) {
      margin-bottom: 16px;
    }

    .product__image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      -o-object-position: center;
      object-position: center;
      -o-object-fit: cover;
      object-fit: cover;
    }

    .product__title {
      display: block;
    }

    .product__title:not(:last-child) {
      margin-bottom: 30px;
    }

    .product__bottom {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 0;
      margin-top: auto;
    }

    .product__prices-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 2px;
    }

    .product__delivery-price {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      gap: 4px;
    }

    .product__delivery-price__icon {
      width: 16px;
      height: 16px;
    }

    .product__delivery-price__title {
      color: #6f797b;
    }

    .product-detail {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 40px;
      padding-bottom: 24px;
    }

    @media screen and (max-width: 991px) {
      .product-detail {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 50px;
        padding-bottom: 0;
      }
    }

    .product-detail .add-to-cart-button {
      margin-top: auto;
    }

    .product-detail__label {
      position: absolute;
      top: 20px;
      left: 20px;
      padding: 4px 16px;
      background-color: #71be38;
      border-radius: 50px;
      font-weight: 300;
      font-size: 18px;
      line-height: 1.25;
      color: #ffffff;
      z-index: 2;
    }

    .product-detail__info {
      width: 100%;
      height: 100%;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .product-detail__info-top {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .product-detail__vendor-code {
      font-weight: 300;
      font-size: 14px;
      color: #6f797b;
      margin-bottom: 10px;
    }

    .product-detail__price {
      font-weight: 600;
      font-size: 36px;
      line-height: 1.16;
      font-stretch: 120%;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      margin-bottom: 6px;
    }

    .product-detail__delivery {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
    }

    .product-detail__delivery-icon {
      width: 24px;
      height: 24px;
    }

    .product-detail__delivery-title,
    .product-detail__delivery-value {
      font-size: 14px;
      color: #6f797b;
    }

    .product-detail__composition {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 5px;
    }

    .product-detail__composition .composition-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 5px;
    }

    .product-detail__composition .composition-item__color {
      width: 18px;
      height: 18px;
      border: 1px solid #dbe4e7;
      border-radius: 50%;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .product-detail__composition .composition-item__title,
    .product-detail__composition .composition-item__quantity {
      font-size: 14px;
      font-weight: 300;
    }

    .product-detail__composition .composition-item__quantity {
      color: #6f797b;
    }

    .product-detail__composition-title {
      font-size: 18px;
    }

    .product-detail__composition-content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 5px;
    }

    .product-detail__discount-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 16px;
    }

    .product-detail__discount {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
    }

    .product-detail__discount-icon {
      width: 24px;
      height: 24px;
    }

    .product-detail__discount-title {
      font-size: 18px;
      color: #71be38;
    }

    .product-detail__discount-condition {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
    }

    .product-detail__discount-condition__title,
    .product-detail__discount-condition__content span {
      font-weight: 300;
      color: #71be38;
    }

    .product-detail__discount-condition__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 5px;
    }

    .section.product-filters {
      margin-top: -48px;
      z-index: 2;
    }

    @media screen and (max-width: 991px) {
      .section.product-filters {
        margin-top: -60px;
      }
    }

    .product-filters__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      padding: 30px 40px;
      background-color: #ffffff;
      border-radius: 36px;
    }

    @media screen and (max-width: 991px) {
      .product-filters__wrap {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        padding: 20px;
        gap: 24px;
      }
    }

    .product-filter {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 15px;
    }

    @media screen and (max-width: 575px) {
      .product-filter {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 10px;
      }
    }

    .product-filter--price .form,
    .product-filter--price .fields {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: nowrap;
      flex-wrap: nowrap;
    }

    .product-filter--price .form {
      gap: 30px;
    }

    @media screen and (max-width: 991px) {
      .product-filter--price .form {
        gap: 16px;
      }
    }

    @media screen and (max-width: 575px) {
      .product-filter--price .form {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 10px;
      }
    }

    .product-filter--price .fields {
      gap: 10px;
    }

    .product-filter--price .inputholder__input {
      text-align: center;
      max-width: 80px;
      padding: 6px 10px;
    }

    .product-filter--price .apply-btn {
      padding: 6px 18px;
    }

    .product-filter--price .inputholder__input.error {
      background-image: none;
    }

    .product-filter--price .error-text {
      display: none;
    }

    .product-filter--sort .product-filter__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 10px;
    }

    .product-filter:last-child {
      margin-left: auto;
    }

    @media screen and (max-width: 991px) {
      .product-filter:last-child {
        margin-left: 0;
      }
    }

    .product-sort {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
    }

    @media (any-hover: hover) {
      .product-sort:hover .product-sort__title {
        color: #f1c1dd;
      }

      .product-sort:hover .product-sort__icon {
        fill: #f1c1dd;
      }
    }

    .product-sort.active .product-sort__title {
      color: #ca4592;
    }

    .product-sort.active .product-sort__icon {
      fill: #ca4592;
    }

    .product-sort--up .product-sort__icon {
      -webkit-transform: rotate(180deg) scale(-1, 1);
      -ms-transform: rotate(180deg) scale(-1, 1);
      transform: rotate(180deg) scale(-1, 1);
    }

    .product-sort__title,
    .product-sort__icon {
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .product-sort__title {
      color: #bfc8cb;
    }

    .product-sort__icon {
      width: 12px;
      height: 16px;
      fill: #bfc8cb;
    }

    .cart__salesman .box {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 25px;
    }

    .cart__salesman .cart__delivery {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 30px;
    }

    .cart__salesman .cart__delivery-title,
    .cart__salesman .cart__delivery-value {
      font-size: 18px;
    }

    .cart__items-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 25px;
    }

    .cart__item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
      position: relative;
    }

    @media screen and (max-width: 767px) {
      .cart__item {
        gap: 10px;
      }
    }

    .cart__item-image__wrap {
      width: 80px;
      height: 80px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      border-radius: 20px;
      overflow: hidden;
    }

    @media screen and (max-width: 767px) {
      .cart__item-image__wrap {
        width: 60px;
        height: 60px;
        border-radius: 12px;
      }
    }

    .cart__item-image {
      width: 100%;
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
    }

    .cart__item-info {
      width: 100%;
      max-width: 515px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
      margin-right: auto;
    }

    @media screen and (max-width: 1199px) {
      .cart__item-info {
        max-width: 220px;
      }
    }

    @media screen and (max-width: 991px) {
      .cart__item-info {
        max-width: 350px;
      }
    }

    @media screen and (max-width: 767px) {
      .cart__item-info {
        gap: 6px;
      }
    }

    .cart__item-title {
      font-size: 16px;
    }

    @media screen and (max-width: 767px) {
      .cart__item-title {
        font-size: 14px;
      }
    }

    .cart__item-label {
      display: -webkit-inline-box;
      display: -ms-inline-flexbox;
      display: inline-flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 10px;
      font-weight: 300;
      color: #ffffff;
      background-color: #71be38;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .cart__item-desc {
      font-size: 12px;
      font-weight: 300;
      color: #6f797b;
      max-width: 320px;
    }

    @media screen and (max-width: 767px) {
      .cart__item-desc {
        display: none;
      }
    }

    .cart__item-price__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: end;
      -ms-flex-align: end;
      align-items: flex-end;
      gap: 2px;
      position: absolute;
      top: 50%;
      right: 50px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }

    @media screen and (max-width: 767px) {
      .cart__item-price__wrap {
        position: static;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-transform: none;
        -ms-transform: none;
        transform: none;
      }
    }

    .cart__item-price:not(.cart__item-price--old) {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
    }

    @media screen and (max-width: 767px) {
      .cart__item-price:not(.cart__item-price--old) {
        font-size: 16px;
        font-weight: 500;
        line-height: 1.25;
      }
    }

    .cart__item-price--old {
      font-size: 12px;
      font-weight: 300;
      color: #6f797b;
      text-decoration: line-through;
    }

    .cart__salesman-bottom {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 25px;
      padding-top: 25px;
      border-top: 1px solid #dbe4e7;
    }

    .cart__recommend .cart__additional-items__wrap {
      padding-top: 20px;
    }

    .cart__additional-items__wrap {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 10px;
    }

    @media screen and (max-width: 767px) {
      .cart__additional-items__wrap {
        grid-template-columns: repeat(1, 1fr);
      }
    }

    .cart__additional-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
      padding: 12px;
      background-color: #f8f7f7;
      border-radius: 24px;
    }

    .cart__additional-item__check {
      width: 16px;
      height: 16px;
      fill: #71be38;
    }

    .cart__additional-item__image-wrap {
      width: 60px;
      height: 60px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      border-radius: 16px;
      overflow: hidden;
    }

    @media screen and (max-width: 1199px) {
      .cart__additional-item__image-wrap {
        width: 50px;
        height: 50px;
      }
    }

    @media screen and (max-width: 991px) {
      .cart__additional-item__image-wrap {
        width: 60px;
        height: 60px;
      }
    }

    .cart__additional-item__image {
      width: 100%;
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
    }

    .cart__additional-item__info {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 8px;
    }

    .cart__additional-item__title,
    .cart__additional-item__price {
      font-size: 13px;
      font-weight: 300;
    }

    .cart__additional-item__price {
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .cart__additional-item__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 6px;
    }

    .cart__summary {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
    }

    .cart__summary .go-to-checkout-button {
      padding-left: 15px;
      padding-right: 15px;
    }

    .cart__summary-heading {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: baseline;
      -ms-flex-align: baseline;
      align-items: baseline;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 10px;
    }

    .cart__summary-title {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      font-stretch: 120%;
    }

    .cart__summary-count {
      font-size: 14px;
      font-weight: 300;
      line-height: 1.18;
      color: #6f797b;
    }

    .cart__summary-items__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 14px;
    }

    .cart__summary-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 30px;
    }

    .cart__summary-item>span {
      font-size: 14px;
      font-weight: 300;
      color: #6f797b;
    }

    .cart__summary-item>span:nth-child(2) {
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .cart__summary-item>span.negative {
      color: #ba1a1a;
    }

    .cart__summary-bottom {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 6px;
      padding-top: 30px;
      border-top: 1px solid #dbe4e7;
    }

    .cart__summary-total {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-stretch: 120%;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .cart__summary-no-discount {
      font-size: 18px;
      font-weight: 400;
      line-height: 1.16;
      color: #6f797b;
    }

    .order-checkout .form__buttonholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
    }

    @media screen and (max-width: 575px) {
      .order-checkout .form__buttonholder {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 20px;
      }
    }

    .order-checkout .fields--checkbox {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .order-checkout .fields:not(:last-child) {
      margin-bottom: 20px;
    }

    @media screen and (max-width: 1199px) {
      .order-checkout .inputholder--width-quarter {
        width: calc(50% - 15px);
      }
    }

    @media screen and (max-width: 575px) {
      .order-checkout .inputholder--width-quarter {
        width: 100%;
      }
    }

    .order-checkout .buttonholder {
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .order-checkout__heading {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
      margin-bottom: 40px;
    }

    @media screen and (max-width: 1199px) {
      .order-checkout__heading {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
      }
    }

    @media screen and (max-width: 1199px) {
      .order-checkout__heading {
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
      }
    }

    @media screen and (max-width: 767px) {
      .order-checkout__heading {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: stretch;
        -ms-flex-align: stretch;
        align-items: stretch;
      }
    }

    .order-checkout__infotext {
      font-size: 12px;
      font-weight: 300;
      max-width: 320px;
    }

    .payment__items-wrap {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 20px;
    }

    @media screen and (max-width: 767px) {
      .payment__items-wrap {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 20px;
        gap: 10px 15px;
      }
    }

    .payment__item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
      position: relative;
      cursor: pointer;
    }

    @media (any-hover: hover) {
      .payment__item:hover .payment__item-image__wrap {
        border-color: #f1c1dd;
      }
    }

    .payment__item input[type=radio]:checked+.payment__item-image__wrap {
      border-color: #ca4592;
    }

    .payment__item input[type=radio]:checked+.payment__item-image__wrap+.payment__item-title {
      color: #ca4592;
    }

    .payment__item-image__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 100%;
      min-height: 145px;
      padding: 20px;
      background-color: #f8f7f7;
      border: 2px solid #f8f7f7;
      border-radius: 24px;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    @media screen and (max-width: 767px) {
      .payment__item-image__wrap {
        min-height: 120px;
      }
    }

    .payment__item-title {
      font-weight: 300;
      font-size: 14px;
      text-align: center;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .personal .form {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 40px;
    }

    @media screen and (max-width: 575px) {

      .personal .submit-button,
      .personal .buttonholder {
        width: 100%;
      }
    }

    .personal .change-email .form__buttonholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
    }

    @media screen and (max-width: 575px) {
      .personal .change-email .form__buttonholder {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .personal .change-email .buttonholder {
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .orders__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .orders__wrap>.show-more-button {
      grid-column: 1/-1;
      margin: 0 auto;
    }

    .order {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 20px;
    }

    .order .leave-review-button {
      margin-left: auto;
    }

    .order__heading .accordion__title {
      font-weight: 300;
    }

    .order__sellers-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
      padding-top: 20px;
    }

    .order__seller {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 20px;
      padding: 20px;
      background-color: #f8f7f7;
      border-radius: 12px;
    }

    .order__seller-heading {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 10px 30px;
    }

    .order__seller-title {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .order__seller-status {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 16px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .order__seller-status--canceled {
      background-color: #ffdad6;
    }

    .order__seller-status--canceled .order__seller-status__title {
      color: #ba1a1a;
    }

    .order__seller-status--canceled .order__seller-status__icon {
      fill: #ba1a1a;
    }

    .order__seller-status--completed {
      background-color: #d9f8c2;
    }

    .order__seller-status--completed .order__seller-status__title {
      color: #71be38;
    }

    .order__seller-status--completed .order__seller-status__icon {
      fill: #71be38;
    }

    .order__seller-status--in-work {
      background-color: #cfeafd;
    }

    .order__seller-status--in-work .order__seller-status__title {
      color: #1098f7;
    }

    .order__seller-status--in-work .order__seller-status__icon {
      fill: #1098f7;
    }

    .order__seller-status__title {
      font-size: 14px;
    }

    .order__seller-status__icon {
      width: 16px;
      height: 16px;
    }

    .order__seller-list {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 10px;
    }

    .order__seller-list__item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 30px;
    }

    .order__seller-list__item>span:nth-child(2) {
      font-weight: 300;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    .order__bottom {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: end;
      -ms-flex-align: end;
      align-items: flex-end;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      gap: 30px;
    }

    .order__info {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 10px 20px;
    }

    .order__info-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-line-pack: inherit;
      align-content: inherit;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 8px;
    }

    .order__info-item__title,
    .order__info-item__value {
      font-size: 14px;
    }

    .order__info-item__value {
      font-weight: 300;
    }

    .sidenav {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 8px;
    }

    .sidenav__item:not(:last-child) .sidenav__link-title {
      color: #ca4592;
    }

    @media (any-hover: hover) {
      .sidenav__item:not(:last-child) .sidenav__link:hover {
        background-color: #ffeaf2;
      }
    }

    .sidenav__item:last-child {
      padding-top: 8px;
      border-top: 1px solid #eff1f2;
    }

    .sidenav__item:last-child .sidenav__link-title {
      color: #ba1a1a;
    }

    @media (any-hover: hover) {
      .sidenav__item:last-child .sidenav__link:hover {
        background-color: #ffdad6;
      }
    }

    .sidenav__link {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 8px;
      padding: 12px;
      border-radius: 12px;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .sidenav__link.active {
      background-color: #fdf2f8;
    }

    .sidenav__link-icon {
      width: 15px;
      height: 15px;
    }

    @media screen and (max-width: 991px) {
      .error404 .return-to-mainpage-button {
        margin-left: auto;
        margin-right: auto;
      }
    }

    .error404__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      padding: 0 20px;
      gap: 46px;
    }

    @media screen and (max-width: 991px) {
      .error404__content {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .error404__text-wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 40px;
      max-width: 620px;
    }

    .error404__text {
      font-size: 18px;
      font-weight: 300;
    }

    .error404__image-wrap {
      width: 100%;
      max-width: 455px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    @media screen and (max-width: 991px) {
      .error404__image-wrap {
        -webkit-box-ordinal-group: 0;
        -ms-flex-order: -1;
        order: -1;
      }
    }

    .error404__image {
      width: 100%;
      height: auto;
      -o-object-fit: contain;
      object-fit: contain;
    }

    .status-page {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
    }

    .status-page__icon {
      width: 64px;
      height: 64px;
    }

    .status-page__title,
    .status-page__text {
      text-align: center;
    }

    .status-page__title {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-stretch: 120%;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .status-page__text {
      font-size: 18px;
    }

    .contacts__main {
      display: grid;
      grid-template-columns: auto 400px;
      grid-gap: 40px;
    }

    @media screen and (max-width: 991px) {
      .contacts__main {
        grid-template-columns: auto;
      }
    }

    @media screen and (max-width: 991px) {
      .contacts__main .box__wrap:nth-child(2) {
        -webkit-box-ordinal-group: 0;
        -ms-flex-order: -1;
        order: -1;
      }
    }

    .contacts__cooperation {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      gap: 24px;
    }

    .contacts__cooperation-image__wrap {
      width: 188px;
      height: 188px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
      border-radius: 24px;
      overflow: hidden;
    }

    .contacts__cooperation-image {
      width: 100%;
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
    }

    .contacts__cooperation-content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 12px;
    }

    .contacts__cooperation-position {
      font-weight: 300;
      color: #6f797b;
    }

    .contacts__cooperation-name {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      font-stretch: 120%;
    }

    @media screen and (max-width: 767px) {
      .contacts__cooperation-name {
        font-size: 24px;
        line-height: 1.16;
      }
    }

    .contacts__cooperation-phone {
      font-size: 18px;
      font-weight: 300;
    }

    @media (any-hover: hover) {
      .contacts__cooperation-phone:hover {
        color: #ae106c;
      }
    }

    .contacts__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 32px;
    }

    .contacts__item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 8px;
      min-height: 62px;
    }

    .contacts__item-title {
      font-weight: 300;
      color: #6f797b;
    }

    .contacts__email,
    .contacts__phone {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.15;
    }

    .contacts__email {
      color: #ca4592;
    }

    @media (any-hover: hover) {
      .contacts__email:hover {
        color: #ae106c;
      }
    }

    @media (any-hover: hover) {
      .contacts__phone:hover {
        color: #ae106c;
      }
    }

    .contacts__social {
      gap: 15px;
    }

    .contacts__social .social__item,
    .contacts__social .social__icon {
      width: 34px;
      height: 34px;
    }

    @media (any-hover: hover) {
      .contacts__social .social__item:hover .social__icon {
        fill: #ae106c;
      }
    }

    .contacts__addresses {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 30px 60px;
    }

    @media screen and (max-width: 991px) {
      .contacts__addresses {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
      }
    }

    .contacts__addresses-content {
      width: 100%;
      max-width: 480px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 30px;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    @media screen and (max-width: 991px) {
      .contacts__addresses-content {
        max-width: 100%;
      }
    }

    .contacts__addresses-search {
      position: relative;
    }

    .contacts__addresses-search .inputholder__input {
      padding-right: 35px;
    }

    .contacts__addresses-search .inputholder__input:focus+.reset-btn {
      background-repeat: no-repeat;
      background-position: center;
      background-size: 16px;
      background-image: url(../img/image/cross.svg);
    }

    .contacts__addresses-search .reset-btn {
      position: absolute;
      top: 50%;
      right: 12px;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 16px;
      background-image: url(../img/image/looking-glass.svg);
    }

    .contacts__addresses-search .reset-btn svg {
      width: 16px;
      height: 16px;
    }

    .contacts__addresses-items__wrap {
      width: calc(100% + 21px);
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 22px;
      max-height: 286px;
      padding-right: 15px;
      overflow: auto;
    }

    @media screen and (max-width: 991px) {
      .contacts__addresses-items__wrap {
        max-height: 206px;
      }
    }

    .contacts__addresses-item {
      position: relative;
    }

    .contacts__addresses-item:not(:last-child)::after {
      content: "";
      width: 100%;
      height: 1px;
      background-color: #eff1f2;
      position: absolute;
      bottom: -11px;
      left: 0;
    }

    .contacts__addresses-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      padding: 10px;
      border-radius: 12px;
      gap: 12px;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      cursor: pointer;
    }

    @media (any-hover: hover) {
      .contacts__addresses-item:hover {
        background-color: #ffeaf2;
      }

      .contacts__addresses-item:hover .contacts__addresses-item__icon {
        fill: #ca4592;
      }
    }

    .contacts__addresses-item.active {
      background-color: #fdf2f8;
    }

    .contacts__addresses-item.active .contacts__addresses-item__icon {
      fill: #ca4592;
    }

    .contacts__addresses-item__icon {
      width: 22px;
      height: 22px;
      fill: #bfc8cb;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .contacts__addresses-item__content {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 8px;
    }

    .contacts__addresses-item__title,
    .contacts__addresses-item__text {
      font-weight: 300;
    }

    .contacts__addresses-item__text {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 6px;
      font-size: 14px;
      color: #6f797b;
    }

    .contacts__map {
      width: 100%;
      border-radius: 24px;
      overflow: hidden;
    }

    .contacts__map .map__holder {
      height: 100%;
    }

    @media screen and (max-width: 991px) {
      .contacts__map .map__holder {
        height: 310px;
      }
    }

    .contacts__bottom {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 40px;
    }

    @media screen and (max-width: 991px) {
      .contacts__bottom {
        grid-template-columns: auto;
      }
    }

    .contacts__bottom-left {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
    }

    .contacts__requisites,
    .contacts__requisites-items__wrap {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 20px;
    }

    .contacts__requisites-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 6px;
    }

    .contacts__requisites-title {
      font-size: 28px;
      font-weight: 600;
      line-height: 1.18;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 25, "YTLC" 525, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
      font-stretch: 120%;
    }

    @media screen and (max-width: 767px) {
      .contacts__requisites-title {
        font-size: 24px;
        line-height: 1.16;
      }
    }

    .contacts__requisites-item__title,
    .contacts__requisites-item__text {
      font-weight: 300;
    }

    .contacts__requisites-item__title {
      color: #6f797b;
    }

    .contacts__requisites-item__text {
      font-size: 18px;
    }

    .contact-us {
      height: 100%;
      min-height: 543px;
    }

    .contact-us>.box {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      height: 100%;
    }

    .contact-us .form {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      gap: 20px;
    }

    .contact-us .form__buttonholder {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 16px;
    }

    @media screen and (max-width: 575px) {
      .contact-us .form__buttonholder {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
      }
    }

    .contact-us .form__policy {
      font-size: 14px;
    }

    .contact-us .form__thanks {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
      -ms-flex-direction: column;
      flex-direction: column;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 20px;
    }

    .contact-us .form__thanks-image__wrap {
      width: 64px;
      height: 64px;
    }

    .contact-us .form__thanks-title,
    .contact-us .form__thanks-text {
      text-align: center;
      font-variation-settings: "GRAD" 0, "slnt" 0, "XTRA" 468, "XOPQ" 96, "YOPQ" 79, "YTLC" 514, "YTUC" 712, "YTAS" 750, "YTDE" -203, "YTFI" 738, "opsz" 43;
    }

    .contact-us .form__thanks-title {
      font-size: 28px;
      font-weight: 600;
      font-stretch: 120%;
      line-height: 118%;
    }

    .contact-us .form__thanks-text {
      font-size: 20px;
      line-height: 115%;
      color: #656565;
    }

    .loading {
      position: relative;
      pointer-events: none;
    }

    .loading::before {
      content: "";
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      background-color: #ffffff;
      opacity: 0.5;
      z-index: 3;
    }

    .loading::after {
      content: "";
      width: 110px;
      height: 110px;
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      background-image: url(../img/image/spinner.svg);
      z-index: 4;
    }

    .accordion__toggle {
      padding: 0 20px 0 0;
      cursor: pointer;
      position: relative;
    }

    .accordion__title {
      font-size: 18px;
    }

    .accordion__btn {
      width: 12px;
      height: 16px;
      position: absolute;
      right: 0;
      top: 50%;
      -webkit-transform: translate(0, -50%);
      -ms-transform: translate(0, -50%);
      transform: translate(0, -50%);
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
    }

    .active .accordion__btn {
      -webkit-transform: translate(0, -50%) rotate(180deg);
      -ms-transform: translate(0, -50%) rotate(180deg);
      transform: translate(0, -50%) rotate(180deg);
    }

    .accordion__btn svg {
      width: 12px;
      height: 16px;
    }

    .accordion__content {
      height: 0;
      overflow: hidden;
    }

    .tabs__nav {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .tabs__nav-item {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 200px;
      border: 1px solid #ffffff;
      padding: 5px 10px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .tabs__nav-item.active {
      border-color: #1a1c18;
      color: #1a1c18;
    }

    .tabs__fold {
      display: none;
    }

    .tabs__fold.open {
      display: block;
    }

    .map {
      position: relative;
    }

    .map__holder--no-touch:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: transparent;
      z-index: 1;
    }

    .map__placemark {
      display: block;
      white-space: nowrap;
      padding: 10px 20px;
      color: var(--color-text-basic);
      width: -webkit-fit-content;
      width: -moz-fit-content;
      width: fit-content;
      border-radius: 20px;
      -webkit-transform: translate(55px, 4px);
      -ms-transform: translate(55px, 4px);
      transform: translate(55px, 4px);
    }

    .counter__wrap--composition {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      gap: 14px;
    }

    @media screen and (max-width: 575px) {
      .counter__wrap--composition {
        gap: 10px;
      }
    }

    .counter__color {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      border: 1px solid #dbe4e7;
      -ms-flex-negative: 0;
      flex-shrink: 0;
    }

    @media screen and (max-width: 575px) {
      .counter__color {
        width: 21px;
        height: 21px;
      }
    }

    .counter__title {
      font-weight: 300;
      margin-right: auto;
    }

    @media screen and (max-width: 575px) {
      .counter__title {
        font-size: 14px;
      }
    }

    .counter {
      margin-left: auto;
    }

    .counter {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      gap: 6px;
    }

    .counter .input {
      width: 50px;
      height: 36px;
      -webkit-box-flex: 0;
      -ms-flex: 0 0 50px;
      flex: 0 0 50px;
      text-align: center;
      background-color: #fffefe;
      border: 2px solid #dbe4e7;
      border-radius: 12px;
    }

    .count {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      color: #71be38;
      border-radius: 12px;
      -webkit-box-flex: 0;
      -ms-flex: 0 0 36px;
      flex: 0 0 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      cursor: pointer;
      background-color: #d9f8c2;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (any-hover: hover) {
      .count:hover {
        background-color: #b1f27e;
      }
    }

    .count--disable {
      color: #d9f8c2;
      background-color: #ecfce1;
      pointer-events: none;
    }

    .tippy-toggler {
      width: 15px;
      height: 15px;
      display: -webkit-inline-box;
      display: -ms-inline-flexbox;
      display: inline-flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      vertical-align: middle;
      margin-left: 7px;
      border-radius: 50%;
      border: 1px solid #bfc8cb;
      cursor: pointer;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      position: relative;
      z-index: 1;
    }

    .tippy-toggler svg {
      width: 5px;
      height: 7px;
      -webkit-transition: 0.3s ease;
      -o-transition: 0.3s ease;
      transition: 0.3s ease;
      fill: #bfc8cb;
    }

    .tippy-box {
      width: 200px;
      font-size: 12px;
      line-height: 1.25;
      font-weight: 300;
      color: #000;
      background-color: #fffefe;
      -webkit-box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
    }

    .tippy-box[data-placement=top-start] {
      border-radius: 12px 12px 12px 0;
    }

    .tippy-box[data-placement=top-start]>.tippy-arrow::before {
      left: -7px;
      border-width: 10px 20px 0 0;
      border-color: #ffffff transparent transparent transparent;
    }

    .tippy-box[data-placement=top-end] {
      border-radius: 12px 12px 0 12px;
    }

    .tippy-box[data-placement=top-end]>.tippy-arrow::before {
      left: -13px;
      border-width: 0 20px 10px 0;
      border-color: transparent #ffffff transparent transparent;
    }

    .tippy-box[data-placement=bottom-start] {
      border-radius: 0 12px 12px 12px;
    }

    .tippy-box[data-placement=bottom-start]>.tippy-arrow::before {
      left: -7px;
      border-width: 10px 0 0 20px;
      border-color: transparent transparent transparent #ffffff;
    }

    .tippy-box[data-placement=bottom-end] {
      border-radius: 12px 0 12px 12px;
    }

    .tippy-box[data-placement=bottom-end]>.tippy-arrow::before {
      left: -13px;
      border-width: 0 0 10px 20px;
      border-color: transparent transparent #ffffff transparent;
    }

    .tippy-box>.tippy-arrow {
      width: 0;
      height: 0;
      border-style: solid;
    }

    .tippy-content {
      padding: 14px;
    }

    .tippy-arrow {
      color: #fffefe;
    }

    .sticky {
      position: relative;
    }

    .sticky__element--fix {
      position: fixed;
      top: 0;
    }

    .sticky__element--absolute {
      position: absolute;
      bottom: 0px;
    }

    .sticky-example {
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-gap: 20px;
      margin-bottom: 30px;
    }

    @media screen and (max-width: 991px) {
      .sticky-example {
        grid-template-columns: 1fr;
      }
    }

    .sticky-example .form {
      margin: 0;
      background: var(--color-bg-primary);
      padding: 20px;
    }

    .sticky-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 10px;
      -webkit-box-align: start;
      -ms-flex-align: start;
      align-items: start;
    }

    @media screen and (max-width: 767px) {
      .sticky-list {
        grid-template-columns: 1fr;
      }
    }

    .sticky-list__item {
      position: relative;
      padding-top: 41px;
    }

    .sticky-list__item ul {
      margin-bottom: 0;
    }

    .sticky-list__title {
      border: 1px solid var(--color-border);
      padding: 5px 10px;
      background-color: var(--color-bg-primary);
    }

    .sticky-list__title:not(.sticky__element--fix):not(.sticky__element--absolute) {
      position: absolute;
      top: 0;
    }

    /*# sourceMappingURL=style.css.map */
  </style>
</head>

<body>
  <header class="header" data-header="data-header">
    <div class="header__row">
      <a class="logo" href="/">
        <img width="140" height="50" style="max-width:140px; max-height:50px;" src="https://цветофор.гики.рф/dist/img/image/logo.png" />
      </a>
      <div class="header__menu" data-header-menu="data-header-menu">
        <div class="header__menu-heading">
          <a class="logo" href="{{ env('APP_URL') }}">
            <img width="140" height="50" style="max-width:140px; max-height:50px;" src="https://цветофор.гики.рф/dist/img/image/logo.png" />
          </a>
          <div class="header__menu-close" data-close-header-menu="data-close-header-menu">

          </div>
        </div>
      </div>
    </div>
  </header>
  <main class="main">
    <div class="heading heading--small-banner">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </main>
  <footer class="footer">
    <div class="container" style="display: flex; justify-content: center; margin-bottom: 40px;">
      @yield('footer')
    </div>
  </footer>
</body>

</html>