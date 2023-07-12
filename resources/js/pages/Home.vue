<template>
    <Title></Title>
    <div class="bg-white w-100 rounded shadow p-3 mb-5">
        <ul class="nav tab align-items-center">
            <li
                v-for="tab in tabs"
                :key="tab.name"
                @click="setActiveTab(tab)"
                class="nav-item"
            >
                <a
                    class="tab-link"
                    :class="{ active: activeTab === tab.name }"
                    data-bs-toggle="tab"
                >
                    {{ tab.name }}</a
                >
            </li>
            <div class="d-flex ms-auto">
                <li><SearchButton /></li>
                <li><ExportButton /></li>
            </div>
        </ul>
        <component :is="getActiveComponent()"></component>
    </div>
    <Modal />
</template>

<script>
import Title from "../components/Title.vue";
import SearchButton from "../components/Home/SearchButton.vue";
import ExportButton from "../components/Home/ExportButton.vue";
import Modal from "../components/Home/Modal.vue";

import TableOpen from "../components/Home/TableOpen.vue";
import TableComplete from "../components/Home/TableComplete.vue";

export default {
    name: "HomePage",
    components: {
        Title,
        SearchButton,
        ExportButton,
        TableOpen,
        TableComplete,
        Modal,
    },
    data() {
        return {
            tabs: [
                // Define your tabs here
                { name: "Open", component: "TableOpen" },
                { name: "Completed", component: "TableComplete" },
            ],
            activeTab: "Open",
        };
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab.name;
        },

        getActiveComponent() {
            const activeTab = this.tabs.find(
                (tab) => tab.name === this.activeTab
            );
            return activeTab ? activeTab.component : null;
        },
    },
};
</script>

<style scoped>
.tab {
    padding: 10px 0px;
    border-bottom: 1px solid #d3d6d8;
}

.tab-link {
    font-weight: 500;
    padding: 0 20px 16px;
    text-decoration: none;
    color: #d3d6d8;
    cursor: pointer;
}

.tab-link.active {
    border-bottom: 3px solid #00bfbf;
    color: #00bfbf;
}
</style>
