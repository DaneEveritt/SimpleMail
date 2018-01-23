<template>
    <form v-if="visible" action="#" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" v-on:submit.prevent="validateForm">
        <div>
            <label class="form-label" for="email">Email Address</label>
            <input class="form-input"
                   id="email"
                   type="email"
                   name="email"
                   aria-label="Email Address"
                   placeholder="leslie@pawnee.gov"
                   :class="{ 'border-red': errors.has('email') }"
                   v-model="email"
                   v-validate="'required|email'"
            >
            <span v-show="errors.has('email')" class="text-red text-xs italic">{{ errors.first('email')}}</span>
        </div>
        <div class="mt-4">
            <label class="form-label" for="message">Message</label>
            <textarea class="form-input"
                      id="message"
                      name="message"
                      aria-label="Message Content"
                      placeholder="I'm writing here to talk to you about someone very special to me, Joe Biden."
                      rows="10"
                      :class="{ 'border-red': errors.has('message') }"
                      v-model="message"
                      v-validate="'required'"
            ></textarea>
            <span v-show="errors.has('message')" class="text-red text-xs italic">{{ errors.first('message')}}</span>
        </div>
        <div class="text-right mt-4 -mb-2" id="form-submit">
            <button type="submit" class="btn btn-blue" aria-label="Submit Form"
                :class="{ 'opacity-50 cursor-not-allowed' : (errors.has('email') || errors.has('message')) }"
            >
                Send Message
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        name: 'send-message',
        data: () => {
            return {
                visible: true,
                email: '',
                message: '',
            }
        },
        methods: {
            formSubmit () {
                axios.post('/send', {
                    email: this.email,
                    message: this.message,
                }).then(() => {
                    this.email = this.message = '';
                    this.$eventBus.$emit('show-success-message', true);
                }).catch(error => {
                    this.$eventBus.$emit('show-error-message', 'There was an error while attempting to submit this form.', true);
                    console.error(error, error.response);
                })
            },
            validateForm() {
                this.$eventBus.$emit('hide-messages');
                this.$validator.validateAll().then(result => {
                    if (result) {
                        return this.formSubmit();
                    }
                })
            },
        },
    }
</script>
