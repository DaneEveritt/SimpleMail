<template>
    <div class="flex mb-6" v-if="visible">
        <div class="w-full h-12">
            <div class="bg-green-lightest border-t-4 border-green rounded-b text-green-darkest px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">Message Sent</p>
                        <p class="text-sm">Your message has been passed off to a fleet of carrier pigeons to guarantee safe delivery.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'message-sent',
        data: () => {
            return {
                visible: false,
            }
        },
        methods: {
            showAlert(toggle) {
                this.visible = toggle;
            },
        },
        mounted() {
            const view = this;
            this.$eventBus.$on('show-success-message', function (toggle) {
                view.showAlert(toggle);
            });

            this.$eventBus.$on('hide-messages', function () {
                view.showAlert(false);
            });
        }
    }
</script>
