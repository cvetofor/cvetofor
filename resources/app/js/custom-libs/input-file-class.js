class loadInputFiles {
  constructor(parentAttr, options) {
    this.options = options;
    this.parentAttr = parentAttr;
    this.classInsert = options.parentClass ? options.parentClass : "fileupload";
    this.inputOrder = 0;
    this.maxFileSize = this.options.maxFileSize;
    this.maxFiles = this.options.maxFiles;
    this.minFiles = this.options.minFiles;
    if (this.parentAttr) {
        let uploadButton = this.parentAttr.querySelector(`[data-fileupload-button]`);
        this.throwErrors();
  
        this.parentAttr.addEventListener("change", (e) => this.attachFile(e.target));
        this.parentAttr.addEventListener("click", (e) => this.deleteButtonEvent(e.target));
        uploadButton.addEventListener("click", (e) => this.uploadButtonEvent(e.currentTarget));
    }
  }

  // вывод ошибки если цифровые значения являются строками
  throwErrors(){
    let numberArr = ['maxFiles', 'maxFileSize', 'minFiles'].filter(el=> typeof this[el] === 'string');
    if(numberArr.length) {
      throw new Error(`Приведите к числу следующие значения: ${numberArr.join(', ')}`)
    }

  }

  clear() {
    if(this.parentAttr) {
      let inputElements =  this.parentAttr.querySelectorAll('[data-fileupload-input], [data-fileupload-list]');
      inputElements.forEach(element=>{
        element.remove();
      });
      this.inputOrder = 0;
      this.parentAttr.querySelector(`[data-fileupload-button]`).style.display = "";
    }
  }

  // событие для кнопки "Прикрепить файл". генерирует инпуты и открывает проводник
  // uploadButton - кнопка загрузки файла
  uploadButtonEvent(uploadButton) {
    let inputTmp = this._createInputTemplate();
    let listTemplate = this._createListTemplate();
    let prevInput = this.parentAttr.querySelector(`[data-fileupload-input="filegroup_${this.inputOrder - 1}"]`);
    let currentInput;

    // добавляем обертку для превью, если её нет
    if (!this.parentAttr.querySelector(`[data-fileupload-list]`)) {
      uploadButton.insertAdjacentHTML("afterEnd", listTemplate);
    }

    // проверяем, если есть предыдущий инпут и он пустой - открываем проводник для этого инпута.
    // иначе генерируем новый инпут и открываем проводник
    if (prevInput && prevInput.value === "") {
      prevInput.click();
    } else {
      uploadButton.insertAdjacentHTML("afterEnd", inputTmp);
      currentInput = this.parentAttr.querySelector(`[data-fileupload-input="filegroup_${this.inputOrder}"]`);
      currentInput.click();
      ++this.inputOrder;
    }
  }

  // событие для кнопки удаления файла
  // current - кнопка удаления файла
  deleteButtonEvent(current) {
    if (current.hasAttribute(`data-fileupload-delete`)) {
      let currentDeleteId = current.getAttribute(`data-fileupload-delete`);

      this.parentAttr.querySelector(`[data-fileupload-button]`).style.display = "";
      this.parentAttr.querySelector(`[data-fileupload-input=${currentDeleteId}]`).remove();
      current.closest(`[data-fileupload-item]`).remove();
    }
  }

  // генерация превью
  // input - текущий инпут
  attachFile(input) {
    if (input === this.parentAttr.querySelector(`[data-fileupload-input]`)) {
      if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = (e) => {
          let currentFile = input.files[0];
          let currentFileSize = currentFile.size;
          let currentFileImage = currentFile.type.split("/")[0] === "image" ? e.target.result : "";
          let currentFileName = currentFile.name;
          let currentInputId = input.getAttribute(`data-fileupload-input`);
          let fileTmp = this._createUploadPreviewTemplate(currentFileImage, currentFileName, currentFileSize, currentInputId);
          let button = this.parentAttr.querySelector(`[data-fileupload-button]`);
          let fileItems;

       

          // если загруженный файл весит больше, чем задано в опциях, то выводим alert с ошибкой. иначе генериуем превью
          if (currentFileSize < this.maxFileSize || !this.maxFileSize) {
            this.parentAttr.querySelector(`[data-fileupload-list]`).insertAdjacentHTML("beforeend", fileTmp);
            fileItems = this.parentAttr.querySelectorAll(`[data-fileupload-item]`).length;

            //если количество загруженных файлов равно максимальному количеству, то скрываем кнопку загрузки
            button.style.display = fileItems === this.maxFiles ? "none" : "";
          } else {
            input.value = "";
            alert(`Размер файла не должен привышать ${this._formatSize(this.maxFileSize)}`);
          }
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  }

  // шаблон для загруженного превью
  // currentFileImage - изображение загруженного файла
  // currentFileName - название загруженного файла
  // currentFileSize - размер загруженного файла
  // currentInputId - уникальнок значение текущего инпута
  _createUploadPreviewTemplate(currentFileImage, currentFileName, currentFileSize, currentInputId) {
    let imageTmp = "";
    let sizeTmp = "";

    if (this.options.createImageThumbnails && currentFileImage) {
      imageTmp = `
        <div class="${this.classInsert}__item-imageholder">
          <img class="${this.classInsert}__item-image" src=${currentFileImage}>
        </div>
      `;
    }

    if (this.options.createSizeThumbnails) {
      sizeTmp = `
        <span class="${this.classInsert}__item-size">
          ${this._formatSize(currentFileSize)}
        </span>
      `;
    }

    let template = `
      <div class="${this.classInsert}__item" data-fileupload-item="">
        ${imageTmp}
        <span class="${this.classInsert}__item-title">${currentFileName}</span>
        ${sizeTmp}
        <div class="${this.classInsert}__item-delete" data-fileupload-delete="${currentInputId}"></div>
      </div>
    `;

    return template;
  }

  // шаблон для инпута
  _createInputTemplate() {
    let acceptTmp = this.options.acceptedFiles ? `accept="${this.options.acceptedFiles}"` : "";
    let nameInputAdd = this.options.nameInput ? `name="${this.options.nameInput}"` : `name="file"`;
    let inputTmp = `
      <input type="file" ${nameInputAdd} ${acceptTmp} class="${this.classInsert}__input" data-fileupload-input="filegroup_${this.inputOrder}">
    `;

    return inputTmp;
  }

  // шаблон для обертки списка превью
  _createListTemplate() {
    let listTemplate = `
      <div class="${this.classInsert}__list" data-fileupload-list=""></div>
    `;

    return listTemplate;
  }

  // перевод байтов в более высокие единицы
  // defaultSize - значение в байтах
  _formatSize(defaultSize) {
    let types = ["байт", "Кб", "Мб", "Гб"];
    let i = parseInt(Math.floor(Math.log(defaultSize) / Math.log(1024)));

    return Math.round(defaultSize / Math.pow(1024, i), 2) + " " + types[i];
  }
}
