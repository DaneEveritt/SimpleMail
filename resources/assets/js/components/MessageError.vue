<template>
    <div class="flex mb-6" v-if="visible">
        <div class="w-full h-12">
            <div class="bg-red-lightest border-t-4 border-red rounded-b text-red-darkest px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-4 text-red-dark"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
                    </div>
                    <div>
                        <p class="font-bold">Error</p>
                        <p class="text-sm">{{ errorMessage }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'message-error',
        data: () => {
            return {
                visible: false,
                errorMessage: '',
            }
        },
        methods: {
            showAlert(message, toggle) {
                this.errorMessage = message;
                this.visible = toggle;
            },
        },
        mounted() {
            const view = this;
            this.$eventBus.$on('show-error-message', function (message, toggle) {
                view.showAlert(message, toggle);
            });

            this.$eventBus.$on('hide-messages', function () {
                view.showAlert('', false);
            });
        }
    }
</script>
