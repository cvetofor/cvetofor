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

      // hiddentCount - скрытое количество товара
      let hiddenCounts = {};
      for (let key in this.form) {
        if (Object.hasOwnProperty.call(this.form, key)) {
          const element = this.form[key];
          let productKey = element.name.replace("[count]", "[products]");

          if (this.selected[productKey] && this.selected[productKey][0]) {
            let product = this.selected[productKey][0];
            let productId = product.id; // Используем идентификатор товара

            // Определение hiddenCount
            hiddenCounts[productId] = hiddenCounts[productId] || 0;
            hiddenCounts[productId] += Number.parseInt(element.value);
          }
        }
      }

      for (let key in this.form) {
        if (Object.hasOwnProperty.call(this.form, key)) {
          const element = this.form[key];

          let count = Number.parseInt(element.value);

          let productKey = element.name.replace("[count]", "[products]");

          if (this.selected[productKey] && this.selected[productKey][0]) {
            let prices = this.selected[productKey][0].prices;

            let price = 0.0;

            let range = [];

            for (let index = 0; index < prices.length; index++) {
              const priceObj = prices[index];
              if (priceObj.price !== null) {
                range.push(Number.parseInt(priceObj.quantity_from));
              }
            }

            if (range.length == 0) {
              this.$store.commit(NOTIFICATION.SET_NOTIF, {
                message:
                  'У товара "' +
                  this.selected[productKey][0].name +
                  '" не установлены цены',
                variant: "error",
              });
            }

            range.push(Number.MAX_VALUE);

            range = range.sort((a, b) => a > b);

            if (range.length % 2 !== 0) {
              range.push(Number.MAX_VALUE);
            }

            let quantityFrom;
            for (let index = 0; index < range.length; index++) {
              for (let j = 0; j < range.length; j++) {
                const r1 = range[index];
                const r2 = range[j];

                if (this.between(hiddenCounts[product.id], r1, r2)) {
                  quantityFrom = r1;
                }
              }
            }

            let priceObj = prices.filter(
              (e) => e.quantity_from == quantityFrom
            );
            if (priceObj[0]) {
              price = Number.parseFloat(priceObj[0].price);
            }
            total += hiddenCounts[product.id] * price;
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
