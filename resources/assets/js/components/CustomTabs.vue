<template>
  <!-- eslint-disable -->

  <div class="custom-tabs">
    <ul class="box__filter">
      <li v-for="tab of tabs">
        <a
          href="#"
          :class="{ 's--on': activeTab === tab.name }"
          @click.prevent="activateTab(tab.name)"
        >
          {{ tab.label }}
        </a>
      </li>
    </ul>

    <slot></slot>
  </div>
</template>



  <script>
/* eslint-disable */

export default {
  props: {
    tabs: { type: Array },
  },

  data() {
    return {
      activeTab: null,
    };
  },

  mounted() {
    if (this.tabs.length > 0) {
      this.activateTab(this.tabs[0].name);
    }
  },

  methods: {
    activateTab(name) {
      this.$el.querySelectorAll(".custom-tab").forEach((tab) => {
        tab.classList.remove("is-active");
      });

      const newActiveTab = this.$el.querySelector(`.custom-tab--${name}`);

      if (newActiveTab) {
        newActiveTab.classList.add("is-active");

        this.activeTab = name;
      }
    },
  },
};
</script>



  <style scoped>
.custom-tabs {
  margin-top: 7px;
}

.custom-tab {
  display: none;
}

.custom-tab.is-active {
  display: initial;
}
</style>
