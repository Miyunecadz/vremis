<template>
  <Head title="My profile"/>

  <BreezeAuthenticatedLayout>
    <template #header>
      Add New User
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">

      <div v-show="$page.props.flash.success"
           class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-center w-12 bg-green-500">
          <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
            </path>
          </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
          <div class="mx-3">
            <span class="font-semibold text-green-500">Success</span>
            <p class="text-sm text-gray-600">{{ $page.props.flash.success }}</p>
          </div>
        </div>
      </div>

      <BreezeValidationErrors class="mb-4"/>

      <form @submit.prevent="submit">
        <div class="px-4 py-3 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <label for="firstname" class="block text-sm font-medium text-gray-700">First name</label>
                <input v-model="form.firstname" type="text" name="firstname" id="firstname" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="lastname" class="block text-sm font-medium text-gray-700">Last name</label>
                <input v-model="form.lastname" type="text" name="lastname" id="lastname" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input v-model="form.username" type="text" name="username" id="username" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>


            <div class="col-span-6 sm:col-span-6">
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input v-model="form.email" type="email" name="email" id="email" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input v-model="form.password" type="password" name="password" id="password" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input v-model="form.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
            </div>

            </div>
        </div>
        <div class="px-4 py-2 sm:px-6">
            <BreezeButton
                class="block w-full"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
            Submit
            </BreezeButton>
        </div>
      </form>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeButton from '@/Components/Button.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    BreezeButton,
    BreezeValidationErrors,
  },

  data() {
    return {
        form: this.$inertia.form({
            firstname: "",
            lastname: "",
            username: "",
            email: "",
            password: "",
            password_confirmation: "",
            terms: false,
        }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route('users.store'), {
        onSuccess: () => this.form.reset(),
        onError: () => this.form.reset('password', 'password_confirmation'),
      });
    },
  },
};
</script>
