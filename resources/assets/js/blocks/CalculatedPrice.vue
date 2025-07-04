<template>
  <!-- eslint-disable -->
  <div class="calculated-price">
    <b>Стоимость -  в ₽ </b>
    <input
      type="number"
      :name="name"
      v-model="value"
      @blur="onBlur"
      @input="onInput"
    />
    <input type="hidden" :name="name" :value="updateVal" />
    <input
      type="button"
      @click="calc()"
      class="button button--validate"
      value="Рассчитать"
    />
  </div>
</template>



  <script>
/* eslint-disable */
import { mapState } from "vuex";
import { NOTIFICATION } from "@/store/mutations";
import InputMixin from "@/mixins/input";
import FormStoreMixin from "@/mixins/formStore";
import InputframeMixin from "@/mixins/inputFrame";

export default {
  mixins: [InputMixin, InputframeMixin, FormStoreMixin],

  props: {
    tabs: { type: Array },
    name: { type: String, default: "" },
    price: { type: Number, default: 0 },
    initialValue: {
      type: Number,
      default: 0,
    },
  },

  data() {
    return {
      value: this.initialValue,
    };
  },

  methods: {
    onInput: function () {
        this.saveIntoStore();
    },
    between: function (x, min, max) {
      return x >= min && x <= max;
    },
    updateFromStore(newValue) {
      if (typeof newValue === "undefined") newValue = "";

      if (this.value !== newValue) {
        this.value = newValue;
      }
    },

    updateValue(newValue) {
      if (this.value !== newValue) {
        this.value = newValue;
        this.saveIntoStore();
      }
    },

    onBlur(event) {
      const newValue = event.target.value;
      this.updateValue(newValue);
    },
    // Взять все выбранные товары и их количество
    // Умножить количество на стоимость
    // Стоимость зависит от количества [1..24],[25..50][51,100][101..]
    calc: function () {
      let total = 0.0;
      // Проходим по всем выбранным товарам (blocks)
      for (let key in this.form) {
        if (Object.hasOwnProperty.call(this.form, key)) {
          const element = this.form[key];
          let count = Number.parseInt(element.value);
          let productKey = element.name.replace("[count]", "[products]");
          if (this.selected[productKey] && this.selected[productKey][0]) {
            let prices = this.selected[productKey][0].prices;
            // Оставляем только валидные цены
            prices = prices.filter(
              (item) =>
                item.price !== undefined &&
                item.price !== null &&
                item.price !== "" &&
                !isNaN(item.price)
            );
            // Сортируем по quantity_from по возрастанию
            prices.sort((a, b) => a.quantity_from - b.quantity_from);
            // Выбираем подходящую цену
            let price = 0;
            let _current = 0;
            if (prices.length > 0) {
              for (let i = 0; i < prices.length; i++) {
                if (prices[i].quantity_from <= count) {
                  _current = i;
                }
              }
              price = Number.parseFloat(prices[_current].price);
              total += price * count;
            } else {
              // Если нет цен, пропускаем
              continue;
            }
          }
        }
      }
      total = Number.parseFloat(total).toFixed(2);
      this.updateValue(total);
      return total;
    },
  },
  computed: {
    updateVal: function () {
      this.updateValue(this.value);
      return this.value;
    },

    ...mapState({
      form: (state) =>
        state.form.fields.filter((e) => e.name.includes("blocks[")),
      selected: (state) =>
        Object.fromEntries(
          Object.entries(state.browser.selected).filter(([key]) =>
            key.includes("[products]")
          )
        ),
    }),
  },
};
</script>



<style lang="scss" scoped>
$height_input: 45px;
$height_btn: 40px;
$height_small_btn: 35px;

.calculated-price {
  background: white;
  margin: 20px 0px;
  color: gray;
}
input[type="search"],
input[type="number"],
input[type="text"],
input[type="email"],
input[type="password"],
input[type="url"] {
  @include resetfield;
  height: $height_input - 2px;
  line-height: $height_input - 2px;
  flex-grow: 1;
  color: inherit;

  background: #fcfcfc;
  padding-left:20px;

  @include placeholder() {
    color: $color__f--placeholder;
  }
}

.button {
  @include btn-reset;
  display: inline-block;
  border-radius: 2px;
  padding: 0 30px;
  height: $height_btn;
  line-height: $height_btn - 2px;
  text-align: center;
  transition: color 0.2s linear, border-color 0.2s linear,
    background-color 0.2s linear;
  text-decoration: none;

  &:disabled {
    cursor: default;
    pointer-events: none;
  }
}

.button--validate {
  margin-top: 30px;
  background: $color__ok;
  color: white;
  @include font-smoothing();

  &:focus,
  &:hover {
    background: $color__ok--hover;
  }

  &:active {
    background: $color__ok--active;
  }

  &:disabled {
    color: $color__button_disabled-text;
    background: $color__button_disabled-bg;
    /*opacity: .5;*/
    pointer-events: none;
  }
}
</style>
