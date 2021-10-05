<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/store-supplier" class="btn btn-rounded btn-primary">Add Supplier</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Supplier List</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Supplier Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="15%">Name</th>
                                        <th>Photo</th>
                                        <th>Phone</th>
                                        <th>Shop Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="supplier in filterSearch" :key="supplier.id">
                                        <td>{{supplier.name}}</td>
                                        <td><img :src="supplier.photo" alt="" id="em_photo"></td>
                                        <td>{{supplier.phone}}</td>
                                        <td>{{supplier.shopname}}</td>
                                        <td>{{supplier.address}}</td>
                                        <td>{{supplier.email}}</td>
                                        <td>
                                            <router-link :to="{name: 'edit-supplier', params:{id:supplier.id}}" class="btn btn-sm btn-warning">
                                                Edit</router-link>
                                            <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger text-white">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>


<script>
export default {
    created() {
        if(!User.loggedIn()){
            this.$router.push({name: '/'})
        }
    },
    data() {
       return {
           suppliers:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.suppliers.filter(supplier => {
                return supplier.name.match(this.searchItem)
            })
        }
    },
    methods: {
        allSupplier() {
            axios.get('/api/supplier')
                .then(({data}) => this.suppliers = data)
                .catch()
        },
        deleteSupplier(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/supplier/' + id)
                .then(() => {
                    this.suppliers = this.suppliers.filter( supplier => {
                        return supplier.id != id
                    })
                })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
        })
    }
    },
    created() {
        this.allSupplier();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>