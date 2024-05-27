<template>
    <div>
        <navBar></navBar>
        <router-view></router-view>
    </div>

</template>

<script>
import { getSessionToken } from '@shopify/app-bridge-utils';
import createApp from '@shopify/app-bridge';
import navBar from "../navigation/navBar";
export default {
    name: "Master",
    mounted() {
        console.log('hi')
    },
    components:{
        navBar,
    },
    async beforeCreate() {
        this.$root.$shopifyApp = createApp({
            apiKey: process.env.MIX_SHOPIFY_API_KEY,
            shopOrigin: this.$route.query.shop,
            host: this.$route.query.host,
            forceRedirect: true,
        });

        window.axios.interceptors.request.use((config) => {
            return getSessionToken(this.$root.$shopifyApp)
                .then((token) => {
                    config.headers["Authorization"] = `Bearer ${token}`;
                    return config;
                });
        });
    },
}
</script>

<style scoped>

</style>
