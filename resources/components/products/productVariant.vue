<template>
    <div>
        <PCard sectioned>
            <PDataTable

                :headings="[
            {
                content: 'Image',
                value: 'image',
                type: 'image',
            },
            {
                content: 'Product',
                value: 'displayName',
                type: 'text',

            },
            {
                content: 'SKU',
                value: 'sku',
                type: 'text',
            },
            {
                content: 'Price',
                value: 'price',
                type: 'numeric',
            },
            {
                content: 'Edit Price',
                value: 'actions',
                type: 'text',
                sortable: false,
            },
        ]"
                :rows='productVariants'

                :hasPagination="true"
                :pagination=pagination

                :loading="loading"
            >
                <template v-slot:item="{item}">
                    <PDataTableRow>
                        <PDataTableCol firstColumn>
                            <template>
                                <PImage v-if="item.node.image"
                                        :source=item.node.image.src
                                        alt="Black choker necklace"
                                        :width="50"
                                        :height="50"
                                />
                                <PImage v-else
                                        source="https://demofree.sirv.com/nope-not-here.jpg"
                                        alt="Black choker necklace"
                                        :width="50"
                                        :height="50"
                                />
                            </template>

                        </PDataTableCol>
                        <PDataTableCol>
                            <PHeading element="h1">{{item.node.displayName}}</PHeading>
                        </PDataTableCol>
                        <PDataTableCol >
                            {{item.node.sku}}
                        </PDataTableCol>
                        <!--                    <PDataTableCol numeric v-if=""></PDataTableCol>-->
                        <PDataTableCol numeric>
                            <template v-if="productData.variantId === item.node.id">
                                <PTextField style="border: 0 none;"
                                            id="input_field"
                                            :minHeight="0"
                                            :multiline="false"
                                            type="text"
                                            :disabled="priceShow"
                                            v-model="item.node.price"
                                            @input="handlePriceChange"
                                />
                            </template>
                            <template v-else>
                                {{item.node.price}}
                            </template>
                        </PDataTableCol>
                        <PDataTableCol>
                            <PStack>
                                <template v-if="productData.variantId === item.node.id">
                                    <PStackItem>
                                        <PIcon source="SaveMinor" @click="updatePrice(item.node.id)"/>
                                    </PStackItem>
                                </template>
                                <template v-else>
                                    <PStackItem>
                                        <PIcon  source="EditMinor" @click="editPrice(item.node.id)"/>
                                    </PStackItem>
                                </template>
                            </PStack>
                        </PDataTableCol>
                    </PDataTableRow>
                </template>

            </PDataTable>
        </PCard>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {

        name: "productVariant",

        data:function () {
            return{
                productVariants:[],
                loading:false,
                priceShow:true,
                params:{},
                after:'',
                before:'',
                productData:{
                    variantId:null,
                    newPrice:null,
                },
                pagination: {
                    hasPrevious: false,
                    hasNext: false,
                    onNext: this.handleNext,
                    onPrevious: this.handlePrevious
                },

            }
        },

        async created() {
            console.log('hellos')
            await this.showProductVariants();
        },

        methods:{

            async showProductVariants(){
                var config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                try{
                    this.loading=true;
                    let {data}=await axios.get('/api/displayProductVariants',{config:config,params:this.params});

                    console.log(data)
                    this.productVariants=data.productVariant;
                    this.pagination.hasNext=data.pageInfo.next;
                    this.pagination.hasPrevious=data.pageInfo.previous;
                    this.after = data.pageInfo.after;
                    this.before = data.pageInfo.before;
                    this.loading=false;
                    delete this.params.after;
                    delete this.params.before;
                }catch(e){

                }
            },

            handleNext(){
                this.params.after = this.after;
                console.log('next')
                this.showProductVariants();
            },
            handlePrevious(){
                this.params.before = this.before;
                console.log('before')
                this.showProductVariants();
            },

            editPrice(id){
                this.productData.variantId=id;
                this.priceShow=false
                console.log(id)
            },

            async updatePrice(id){
                this.priceShow=true
                if(this.productData.newPrice!= null) {
                    console.log('gfh')
                    try{
                        let {data}= await axios.post('api/updateProductVariantPrice',{id:id,price:this.productData.newPrice});
                        alert("Product Price Update Successfully...")

                    }catch(e){
                    }
                }
                this.productData.variantId=null;
                this.price=null;
            },

            handlePriceChange(price){
                console.log(price)
                this.productData.newPrice=price

                console.log(this.productData.newPrice)
            },

        }
    }
</script>

<style scoped>

</style>
