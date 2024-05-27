<template>
<div>
    <PDisplayText style="text-align:center">Products</PDisplayText>


        <PCard style="margin: 20px">
            <PTabs
                :tabs='[
                    {"id":"all","content":"All"},
                    {"id":"new","content":"New"},
                    {"id":"variants","content":"Variants"}
                    ]'
                @select="tab"
            >
            </PTabs>
        </PCard>
    <PCard style="margin: 20px">
        <p v-if="tabIndex === 0">
            <all-product></all-product>
        </p>
        <p v-if="tabIndex ===1">
            <new-product></new-product>
        </p>
        <p v-if="tabIndex ===2">
           <product-variant></product-variant>
        </p>
    </PCard>
</div>
</template>

<script>
    import NewProduct from "./newProduct";
    import AllProduct from "./allProduct";
    import ProductVariant from "./productVariant";
    export default {
        name: "products",
        components: {ProductVariant, AllProduct, NewProduct},

        data:function () {
            return{
                tabIndex:0,
            }
        },
        methods:{
            tab(id){
                this.tabIndex=id;
            }
        }

    }
</script>

<style scoped>

</style>
