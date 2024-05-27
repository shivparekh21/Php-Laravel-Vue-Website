<template>
    <div>
        <template>

            <PCard sectioned>
                <PDataTable
                    :headings="[

               {
                     content:'Id',
                     value:'id',
                     type:'text'
               },
               {
                    content:'Image',
                    value:'image',
                    type:'image'
               },
                {
                    content:'Name',
                    value:'title',
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

                                {{item.id}}

                            </PDataTableCol>
                            <PDataTableCol>
                                <template>
                                    <PImage v-if="item.image"
                                            :source=item.image.src
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
                                <PHeading element="h1">{{item.title}}</PHeading>
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
        name: "newProduct",
        data:function () {
            return{
                products:[],
            }
        },
        async created() {
            await this.showProduct();
        },
        methods:{
            async showProduct(){

                try{
                    let {data}=await axios.get('/api/displayProduct');
                    console.log(data)
                    this.products=data;
                    console.log('hil'.this.products);
                }catch(e){

                }

            },
        }
    }
</script>

<style scoped>

</style>
