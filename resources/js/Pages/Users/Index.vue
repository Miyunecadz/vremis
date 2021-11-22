<template>
  <Head title="Users"/>

  <BreezeAuthenticatedLayout>
  <template #header>
    List of Users
  </template>

  <div class="p-4 bg-white rounded-lg shadow-xs">
    <!-- <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
      <div class="flex justify-center items-center w-12 bg-blue-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
        </svg>
      </div>

      <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
          <span class="font-semibold text-blue-500">Info</span>
          <p class="text-sm text-gray-600">Sample table page</p>
        </div>
      </div>
    </div> -->

    <div class="flex gap-2 mb-2">
        <div class="mr-auto">
            <input id="search" type="text" v-model="keyword" @keyup="search" class="block mt-1 w-full rounded" placeholder="Search">
        </div>

        <Link :href="route('users.create')"  class="bg-blue-700 hover:bg-blue-500 text-white font-bold py-3 text-sm px-3 rounded flex" >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            New User
        </Link>
    </div>

    <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
      <div class="min-w-full divide-y">
        <table class="w-full whitespace-no-wrap">
          <thead>
          <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Username</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Actions</th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y">
            <tr v-for="user in users.data" :key="user.id" class="text-gray-700">
                <td class="px-4 py-3 text-sm">
                    {{ user.firstname }} {{ user.lastname }}
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ user.username }}
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ user.email }}
                </td>
                <td class="px-1 py-3 text-sm flex gap-2">
                    <a href="#" title="Edit User">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>
                    <a href="#" @click="deleteUser(user)" type="button" title="Delete User">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </a>
                    <a href="#" @click="resetPass(user)" title="Reset Password">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                </td>
            </tr>
            <tr v-if="users.data.length == 0" class="text-gray-700">
                <td class="px-4 py-3 text-sm text-center" colspan="4">
                    No data found
                </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div
          class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
        <pagination :links="users.links" />
      </div>
    </div>
  </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Button from '@/Components/Button.vue';
import Link from '@/Components/Link.vue'
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/inertia-vue3';


export default {
  components: {
    BreezeAuthenticatedLayout,
    Pagination,
    Button,
    Link,
    Head
  },

  props: {
    users: Object,
  },
  data(){
      return{
          keyword: ''
      }
  },
  methods:{
      search(){
          this.$inertia.replace(this.route('users.index', {keyword: this.keyword}))
      },
      deleteUser: function(user){
          if (!confirm('Are you sure want to remove?')) return;
          user._method = "DELETE"
          this.$inertia.delete(route('users.delete',user))
      },
      resetPass: function(user){
          if(!confirm('Are you sure you want to reset password?')) return;
          this.$inertia.put(route('users.reset', user))
      }
  }
}
</script>
