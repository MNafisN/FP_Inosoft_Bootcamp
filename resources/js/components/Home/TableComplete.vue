<template>
    <template v-if="listInt && listInt.length">
        <div class="mt-4">
            <DataTable v-if="!onSearch" class="table table-hover display" :options="options" @update="filteredData">
                <thead>
                    <tr class="table-secondary">
                        <th>Instruction ID</th>
                        <th>Link To</th>
                        <th class="text-center">Instuction Type</th>
                        <th>Assigned Vendor</th>
                        <th>Issued Date</th>
                        <th>Attention Of</th>
                        <th>Quotation No.</th>
                        <th>Invoice</th>
                        <th>Customer PO</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filteredData" :key="index">
                        <td
                            class="cursor-pointer"
                            scope="row"
                            @click="selectDetail(item.instruction_id)"
                        >
                            {{ item.instruction_id }}
                        </td>
                        <td>{{ item.transaction_code }}</td>
                        <td class="text-center">
                            <Type :type="item.instruction_type" />
                        </td>
                        <td>{{ item.assigned_vendor }}</td>
                        <td>{{ formatDate(item.created_at) }}</td>
                        <td>{{ item.attention_of }}</td>
                        <td>{{ item.quotation_number }}</td>
                        <td>
                            <Invoice
                                :invoice="item.invoices"
                                :id="item.instruction_id"
                            />
                        </td>
                        <td>{{ item.cust_po_number }}</td>
                        <td>
                            <Pills
                                :type="item.instruction_status"
                                :termination="item.termination"
                            />
                        </td>
                    </tr>
                </tbody>
            </DataTable>
        </div>
    </template>
    <template v-else>
        <Skeleton />
    </template>
</template>

<script>
import { reactive, toRefs } from "vue";
import { mapGetters } from "vuex";

import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net-bs5";
import moment from "moment";

import Invoice from "./Table/Invoice.vue";
import Type from "./Table/Type.vue";
import Pills from "./Table/Pills.vue";
import Skeleton from "./Table/TableSkeleton.vue";

DataTable.use(DataTablesCore);

const options = {
    searching: false,
};

export default {
    setup() {
        const state = reactive({ listInt: [] });

        axios
            .get("http://127.0.0.1:8000/api/instruction/list/completed")
            .then((response) => {
                state.listInt = response.data.data;
            })
            .catch((error) => {
                console.error(error);
            });

        return { ...toRefs(state) };
    },
    components: {
        DataTable,
        Invoice,
        Type,
        Pills,
        Skeleton,
    },
    data() {
        return {
            options: options,
            onSearch: false,
        };
    },
    computed: {
        ...mapGetters({
            searchText: "getSearchInput",
        }),
        filteredData() {
            this.onSearch = true;
            if (!this.searchText) {
                setTimeout(()=>{
                    this.onSearch = false;
                }, 100)
                return this.listInt;
            }
            setTimeout(()=>{
                this.onSearch = false;
            }, 100)
            const searchTextLowerCase = this.searchText.toLowerCase();
            return this.listInt.filter((item) =>
                Object.values(item).some((value) =>
                    String(value).toLowerCase().includes(searchTextLowerCase)
                )
            );
        },
    },
    watch: {
        searchText: {
            handler() {
                this.filteredData;
            },
            immediate: true,
        },
    },
    methods: {
        formatDate(dateString) {
            return moment(dateString).format("DD/MM/YY");
        },
        selectDetail(instruction_id) {
            this.$router.push(`/app/detail-instruction/${instruction_id}`);
        },
    },
};
</script>
<style scoped>
.dataTables_length{
    display: none;
}
</style>
