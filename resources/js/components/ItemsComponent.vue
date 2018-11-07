<template>
    <div class="row">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="m-0">Add Item</h5>
          </div>
         <form @submit.prevent="addItem()">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Item Name</label>
                    <input v-model="form.item_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('item_name') }">
                    <has-error :form="form" field="item_name"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="name">Item Code</label>
                    <input v-model="form.item_code" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('item_code') }">
                    <has-error :form="form" field="item_code"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="name">Item Price</label>
                    <input v-model="form.item_price" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('item_price') }">
                    <has-error :form="form" field="item_price"></has-error>
                  </div>
                </div>
                <div class="card-footer">
                  <button :disabled="form.busy" type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h5 class="m-0">Items</h5>
          </div>
          <div class="card-body p-0">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Item Price</th>
                    <th>Created By</th>
                    <th>Time</th>
                    <th></th>
                  </tr>
                  <tr v-for="item in items" v-bind:key="item.id">
                    <td>{{item.name}}</td>
                    <td>{{item.code}}</td>
                    <td>${{item.price}}</td>
                    <td>{{item.created_by}}</td>
                    <td>{{item.time}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" @click="editItem(item)">Edit</a>
                                <a class="dropdown-item" href="#" @click="deleteItem(item.id)">Delete</a>
                            </div>
                        </div>
                    </td>
                  </tr>
                </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchItems(pagination.prev_page_url)"><a class="page-link" href="#">«</a></li>
                  <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                  <li class="page-item"  v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetchItems(pagination.next_page_url)"><a class="page-link" href="#">»</a></li>
                </ul>
              </div>
        </div>
      </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      items: [],
      form: new Form({
        iditems: null,
        item_name: "",
        item_code: "",
        item_price: "",
        user_id: this.userId,
      }),
      item_id: "",
      API_URL: "api/items",
      edit: false,
      pagination: {}
    };
  },
  props: {
    userId: 0
  },
  created() {
    this.fetchItems();
  },
  methods: {
    async fetchItems(page_url) {
      try {
        let vm = this;
        page_url = page_url || this.API_URL;
        const response = await axios.get(page_url);
        this.items = response.data.data;
        vm.makePagination(response.data.meta, response.data.links);
      } catch (e) {
        console.log(e);
      }
    },
    async addItem() {
      if (this.edit == false) {
        try {
          const response = await this.form.post(this.API_URL);
          $.alert({
            icon: "fa fa-smile",
            theme: "modern",
            animation: "scale",
            closeAnimation: "zoom",
            title: "Success!",
            content:
              "Item has been successfully saved.",
            draggable: false,
            buttons: {
              ok: function() {
                
              }
            }
          });
          this.form.clear();
          this.form.reset();
          this.fetchItems();
        } catch (e) {
          console.log(e);
        }
      } else {
        try {
          const response = await this.form.put(this.API_URL+'/'+this.form.iditems);
          $.alert({
            icon: "fa fa-smile",
            theme: "modern",
            animation: "scale",
            closeAnimation: "zoom",
            title: "Success!",
            content:
              "Item has been successfully updated.",
            draggable: false,
            buttons: {
              ok: function() {
                
              }
            }
          });
          this.form.clear();
          this.form.reset();
          this.edit = false;
          this.fetchItems();
        } catch (e) {
          console.log(e);
        }
      }
    },
    editItem(item){
        this.edit = true;
        this.form.iditems=item.id;
        this.form.item_name=item.name;
        this.form.item_code=item.code;
        this.form.item_price=item.price;
    },
    async deleteItem(id){
        try {
          let vm = this;
          $.confirm({
                title: 'Delete',
                content: 'Are you sure you want to delete this?',
                buttons: {
                     confirm: async function () {
                       const response = await vm.form.delete(vm.API_URL+'/'+id);
                        $.alert({
                            animation: 'scale',
                            closeAnimation: 'zoom',
                            title: 'Success!',
                            content: 'Branch has been deleted',
                        });
                        vm.fetchItems();
                    },
                    cancel: function(){

                    }
                }
            });
        } catch (e) {
          console.log(e);
        }
    },
    makePagination(meta, links){
        let pagination = {
            current_page: meta.current_page,
            last_page: meta.last_page,
            next_page_url: links.next,
            prev_page_url: links.prev,
        };
        this.pagination=pagination;
    }
  }
};
</script>
