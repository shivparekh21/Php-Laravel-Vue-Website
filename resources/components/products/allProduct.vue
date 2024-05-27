<template>
    <div>

        <template>

            <PCard sectioned>
                <PDataTable
                    :resourceName="{singular: 'Product', plural: 'Products'}"
                    :headings="[

           {
                 content:'Id',
                 value:'shopify_id',
                 type:'text'
           },
           {
                content:'Image',
                value:'image',
                type:'image'
           },
            {
                content:'Name',
                value:'product_title',
                type:'text',
                // width:'30%'
            },
            {
                content:'Product Handle',
                value:'handle',
                type:'text'
            },

        ]"
                    :rows=products
                    :hasPagination="true"
                    :pagination="{
            hasPrevious: true,
            hasNext: true,
            onNext: () => {
                alert('Next');
            },
            onPrevious: () => {
                alert('Previous');
            }
        }"
                >
                    <template v-slot:item="{item}">
                        <PDataTableRow>

                            <PDataTableCol firstColumn>

                                {{item.shopify_id}}

                            </PDataTableCol>
                            <PDataTableCol>
                                <PImage
                                    :source=item.image
                                    alt="Black choker necklace"
                                    :width="50"
                                    :height="50"
                                />

                            </PDataTableCol>
                            <PDataTableCol >
                                <PHeading element="h1">{{item.product_title}}</PHeading>
                            </PDataTableCol>
                            <PDataTableCol>
                                {{item.handle}}
                            </PDataTableCol>



                        </PDataTableRow>
                    </template>
                </PDataTable>
            </PCard>
        </template>



    </div>
</template>

<script>
    export default {
        name: "allProduct",
        data:function () {
            return{
                products:[],
            }
        },
        async created() {
            // await this.syncProduct();
            await this.showProduct();
        },
        methods:{
            // async syncProduct(){
            //     let {data}=await axios.get('/api/syncProduct');
            // },
            async showProduct(){
                let {data}=await axios.get('/api/showProduct');
                this.products=data;
                // console.log(this.products);
            }
        }
    }
</script>

<style scoped>

</style>
