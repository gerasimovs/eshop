<template>
  <section>
    <BNavbar wrapper-class="container">
      <template #brand>
        <b-navbar-item>SPA EShop</b-navbar-item>
      </template>
    </BNavbar>
    <main>
      <div class="container">
        <div class="columns is-multiline">
          <div class="column is-4">
            <Product class="has-background-grey-lighter" v-bind="randomProduct" :currencyRate="currencyRate" :currency="currency" ></Product>
          </div>
          <div v-for="product in products" class="column is-4">
            <Product v-bind="product" :currencyRate="currencyRate" :currency="currency" :key="product.id"></Product>
          </div>
        </div>
        <BPagination
            :total="total"
            :perPage="perPage"
            :current.sync="currentPage"
            @change="(page) => {this.currentPage = page; this.getProducts()}">

          <b-pagination-button
              slot="previous"
              slot-scope="props"
              :page="props.page">
            Previous
          </b-pagination-button>

          <b-pagination-button
              slot="next"
              slot-scope="props"
              :page="props.page">
            Next
          </b-pagination-button>

        </BPagination>
      </div>
      <b-loading :is-full-page="true" v-model="isLoading" :can-cancel="true"></b-loading>
    </main>
  </section>
</template>

<script>
  import axios from 'axios';
  import Product from './components/Product';

  export default {
    data() {
      return {
        loaders: 0,

        total: 0,
        perPage: 1,
        currentPage: 1,

        products: [],
        randomProduct: null,

        currency: 'USD',
        currencyRate: 1,
      };
    },
    computed: {
      isLoading() {
        return this.loaders > 0
      },
    },
    components: {Product},
    methods: {
      async getProducts() {
        this.loaders += 1;

        const {data: {items, total, perPage}} = await axios.get('/api/products', {
          params: {page: this.currentPage},
        });

        this.products = items;
        this.total = total;
        this.perPage = perPage;

        this.loaders -= 1;
      },
      async getRandomProduct() {
        this.loaders += 1;
        const {data} = await axios.get('/api/products/random');
        this.randomProduct = data;
        this.loaders -= 1;
      },
      async getCurrencyRate() {
        this.loaders += 1;
        const {data: {currency, rate}} = await axios.get('/api/currencies/rate');
        this.currency = currency;
        this.currencyRate = rate;
        this.loaders -= 1;
      },
    },
    mounted() {
      this.getCurrencyRate();
      this.getProducts();
      this.getRandomProduct();
    },
  }
</script>