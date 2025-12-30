<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import InputIcon from 'primevue/inputicon';
import IconField from 'primevue/iconfield';
import { FilterMatchMode } from '@primevue/core/api';
import WebsiteMonitorListener from '@/components/Listeners/WebsiteMonitorListener.vue';

const props = defineProps({
    clients: {
        required: true,
        type: Array
    },
    websites: {
        required: true,
        type: Array
    },
    monitorLogs: {
        required: true,
        type: Array
    }
});

const selectedClient = ref(null);
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});

// Format clients for dropdown with email and website count
const clientOptions = computed(() => {
    return props.clients.map(client => ({
        email: client.email,
        websiteCount: client.website_count || 0,
        label: `${client.email} (${client.website_count || 0} websites)`,
        id: client.id
    }));
});

// Filter monitoring logs based on selected client
const filteredMonitorLogs = computed(() => {
    if (!selectedClient.value) {
        return props.monitorLogs;
    }

    return props.monitorLogs.filter(log =>
        log.client && log.client.email === selectedClient.value.email
    );
});

// Format date helper
const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

// Get status badge class
const getStatusClass = (status) => {
    // Assuming status values: 'up', 'down', 1, 0, true, false, 200, etc.
    if (status === 'up' || status === 1 || status === true || status === 200) {
        return 'badge-success';
    }
    return 'badge-danger';
};

// Format status text
const formatStatus = (status) => {
    if (status === 'up' || status === 1 || status === true || status === 200) {
        return 'UP';
    }
    return 'DOWN';
};

// Open website in new tab
const visitWebsite = (url) => {
    if (url) {
        window.open(url, '_blank');
    }
};

// Clear filter
const clearClientFilter = () => {
    selectedClient.value = null;
};
</script>

<template>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-xl-4 col-sm-7 box-col-3">
                        <h3>Website Monitoring Logs</h3>
                    </div>
                    <div class="col-5 d-none d-xl-block"></div>
                    <div class="col-xl-3 col-sm-5 box-col-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <Link href="/">
                                    <svg class="stroke-icon">
                                        <use href="/assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
                                </Link>
                            </li>
                            <li class="breadcrumb-item">Monitoring</li>
                            <li class="breadcrumb-item active">Logs</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Client Filter Section -->
                            <div class="mb-4">
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Filter by Client</label>
                                        <Select
                                            v-model="selectedClient"
                                            :options="clientOptions"
                                            filter
                                            optionLabel="label"
                                            placeholder="Select a client to filter"
                                            class="w-100"
                                            :showClear="true"
                                        >
                                            <template #value="slotProps">
                                                <div v-if="slotProps.value" class="flex align-items-center">

                                                    <div>
                                                        <strong>{{ slotProps.value.email }}</strong>
                                                        <span class="text-muted ms-2">({{ slotProps.value.websiteCount }} websites)</span>
                                                    </div>
                                                </div>
                                                <span v-else>
                                                    {{ slotProps.placeholder }}
                                                </span>
                                            </template>
                                            <template #option="slotProps">
                                                <div class="flex align-items-center">

                                                    <div>
                                                        <strong>{{ slotProps.option.email }}</strong>
                                                        <span class="badge badge-info ms-2">{{ slotProps.option.websiteCount }} websites</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </Select>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button
                                            v-if="selectedClient"
                                            class="btn btn-secondary"
                                            @click="clearClientFilter"
                                        >
                                            <i class="pi pi-times"></i> Clear Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- DataTable -->
                            <div class="list-product">
                                <div class="table-responsive">
                                    <DataTable
                                        v-model:filters="filters"
                                        :value="filteredMonitorLogs"
                                        showGridlines
                                        stripedRows
                                        paginator
                                        :rows="10"
                                        :rowsPerPageOptions="[10, 25, 50, 100]"
                                        tableStyle="min-width: 50rem"
                                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} logs"
                                        :globalFilterFields="['client.email', 'website.name', 'website.url']"
                                    >
                                        <template #header>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="pi pi-list"></i>
                                                    Monitoring Logs
                                                    <span class="badge badge-primary ms-2">{{ filteredMonitorLogs.length }}</span>
                                                </h5>
                                                <IconField>
                                                    <InputIcon>
                                                        <i class="pi pi-search" />
                                                    </InputIcon>
                                                    <InputText
                                                        v-model="filters['global'].value"
                                                        placeholder="Search logs..."
                                                    />
                                                </IconField>
                                            </div>
                                        </template>

                                        <!-- Email Column -->
                                        <Column field="client.email" header="Client Email" sortable style="min-width: 200px">
                                            <template #body="slotProps">
                                                <div class="d-flex align-items-center">
                                                    <i class="pi pi-user text-primary me-2"></i>
                                                    <a :href="`mailto:${slotProps.data.client?.email}`" class="text-primary">
                                                        {{ slotProps.data.client?.email || 'N/A' }}
                                                    </a>
                                                </div>
                                            </template>
                                        </Column>

                                        <!-- Website Column -->
                                        <Column field="website.name" header="Website" sortable style="min-width: 250px">
                                            <template #body="slotProps">
                                                <div>
                                                    <strong>{{ slotProps.data.website?.name || 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ slotProps.data.website?.url || 'N/A' }}</small>
                                                </div>
                                            </template>
                                        </Column>

                                        <!-- Visit Website Column -->
                                        <Column header="Visit" style="min-width: 100px">
                                            <template #body="slotProps">
                                                <button
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="visitWebsite(slotProps.data.website?.url)"
                                                    :disabled="!slotProps.data.website?.url"
                                                >
                                                    <i class="pi pi-external-link"></i> Visit
                                                </button>
                                            </template>
                                        </Column>

                                        <!-- Status Column -->
                                        <Column field="status" header="Status" sortable style="min-width: 120px">
                                            <template #body="slotProps">
                                                <span :class="['badge', 'badge-lg', getStatusClass(slotProps.data.status)]">
                                                    <i :class="['pi', slotProps.data.status === 'up' || slotProps.data.status === 1 || slotProps.data.status === 200 ? 'pi-check-circle' : 'pi-times-circle']"></i>
                                                    {{ formatStatus(slotProps.data.status) }}
                                                </span>
                                            </template>
                                        </Column>

                                        <!-- Last Checked Column -->
                                        <Column field="last_monitored" header="Last Checked" sortable style="min-width: 180px">
                                            <template #body="slotProps">
                                                <div class="d-flex align-items-center">
                                                    <i class="pi pi-clock text-muted me-2"></i>
                                                    {{ formatDate(slotProps.data.last_monitored) }}
                                                </div>
                                            </template>
                                        </Column>

                                        <!-- Empty State -->
                                        <template #empty>
                                            <div class="text-center p-5">
                                                <i class="pi pi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                                <p class="text-muted mt-3 mb-0">
                                                    {{ selectedClient ? 'No monitoring logs found for this client.' : 'No monitoring logs available.' }}
                                                </p>
                                            </div>
                                        </template>
                                    </DataTable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    <WebsiteMonitorListener />
</template>

<style scoped>
    .p-datatable-tbody > tr {
    background: white !important;
}
.badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
    font-weight: 500;
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.badge-info {
    background-color: #17a2b8;
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.badge-primary {
    background-color: #007bff;
    color: white;
}

.text-primary {
    color: #007bff !important;
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}

.text-muted {
    color: #6c757d !important;
}

.btn-outline-primary {
    color: #007bff;
    border: 1px solid #007bff;
    background: transparent;
    padding: 0.25rem 0.75rem;
}

.btn-outline-primary:hover:not(:disabled) {
    background-color: #007bff;
    color: white;
}

.btn-outline-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.p-datatable-tbody > tr {
    background: white !important;
}

.fw-bold {
    font-weight: bold;
}

.mr-2 {
    margin-right: 0.5rem;
}

.ms-2 {
    margin-left: 0.5rem;
}

.me-2 {
    margin-right: 0.5rem;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.justify-content-between {
    justify-content: space-between;
}

.text-end {
    text-align: right;
}

.w-100 {
    width: 100%;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mb-0 {
    margin-bottom: 0;
}

.mt-3 {
    margin-top: 1rem;
}

.p-5 {
    padding: 3rem;
}

/* PrimeVue Select styling */
:deep(.p-select) {
    width: 100%;
}

:deep(.p-select-label) {
    display: flex;
    align-items: center;
}
</style>
