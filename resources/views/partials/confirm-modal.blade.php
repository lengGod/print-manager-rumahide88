<div x-data="confirmModal()" x-show="show" @open-confirm-modal.window="open($event.detail)" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
    <!-- Backdrop -->
    <div x-show="show" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <!-- Modal Panel -->
    <div x-show="show" x-transition:enter="transition-all ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition-all ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @click.away="close()"
        class="relative w-full max-w-md bg-white dark:bg-slate-800 rounded-xl shadow-lg">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div :class="{
                    'bg-rose-100 dark:bg-rose-500/20': type === 'danger',
                    'bg-amber-100 dark:bg-amber-500/20': type === 'warning',
                    'bg-blue-100 dark:bg-blue-500/20': type === 'info'
                }"
                    class="flex-shrink-0 size-10 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined"
                        :class="{
                            'text-rose-600 dark:text-rose-400': type === 'danger',
                            'text-amber-600 dark:text-amber-400': type === 'warning',
                            'text-blue-600 dark:text-blue-400': type === 'info'
                        }"
                        x-text="icon"></span>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white" x-text="title"></h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400" x-html="message"></p>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 rounded-b-xl flex justify-end items-center gap-3">
            <button @click="close()" type="button"
                class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 dark:ring-offset-slate-900">
                Batal
            </button>
            <button @click="confirm()" type="button"
                :class="{
                    'bg-rose-600 hover:bg-rose-700 focus:ring-rose-500': type === 'danger',
                    'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500': type === 'warning',
                    'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500': type === 'info'
                }"
                class="px-4 py-2 text-sm font-medium text-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 dark:ring-offset-slate-900">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    function confirmModal() {
        return {
            show: false,
            title: '',
            message: '',
            type: 'danger', // danger, warning, info
            icon: 'delete',
            targetUrl: '',
            form: null,
            open(detail) {
                this.title = detail.title || 'Anda yakin?';
                this.message = detail.message || 'Aksi ini tidak dapat dibatalkan.';
                this.type = detail.type || 'danger';
                this.targetUrl = detail.targetUrl || '';
                this.icon = {
                    danger: 'delete',
                    warning: 'warning',
                    info: 'info'
                } [this.type];
                this.show = true;

                // If a form ID is passed, find the form
                if (detail.formId) {
                    this.form = document.getElementById(detail.formId);
                }
            },
            close() {
                this.show = false;
                this.form = null; // Reset form
            },
            confirm() {
                if (this.form) {
                    this.form.submit();
                } else if (this.targetUrl) {
                    window.location.href = this.targetUrl;
                }
                this.close();
            }
        }
    }
</script>
