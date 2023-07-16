import axios from "axios";
import { createStore } from "vuex";

const INITIAL_STATE = {
    instruction_id: "",
    instruction_type: "Logistic Instruction",
    assigned_vendor: "",
    vendor_address: "",
    attention_of: "",
    quotation_number: null,
    invoice_to: "",
    customer_contact: "",
    cust_po_number: "",
    cost_detail: [
        {
            cost_description: "",
            quantity: 0,
            unit_of_measurement: "PCS",
            unit_price: 0,
            GST_percentage: 0,
            currency: "",
            vat_amount: 0,
            sub_total: 0,
            total: 0,
            charge_to: "",
        },
    ],
    attachment: [],
    notes: null,
    transaction_code: "",
    invoices: [],
    termination: {},
    instruction_status: "Draft",
}

const store = createStore({
    state() {
        return {
            instructionData: JSON.parse(JSON.stringify(INITIAL_STATE)),
            internalOnly: {
                attachment: [
                    {
                        name: "file1.jpg",
                        info: "by Irfan Faqih on 26/04/22 11:43 AM",
                        link: "",
                    },
                ],
                notes: [
                    {
                        value: "ini adalah contoh untuk notes",
                        user: "User",
                        time: "08/07/23 05:12 PM",
                    },
                ],
            },
            termination: {
                termination_reason: "",
                attachment: []
            },
            formData: {
                customers: [],
                transactions: [],
                vendors: [],
            },
        };
    },
    getters: {
        getStatus(state) {
            return state.instructionData.instruction_status;
        },
        getId(state) {
            return state.instructionData.instruction_id;
        },
        listCostTable(state) {
            return state.instructionData.cost_detail.length;
        },
        getInstructionDetail(state) {
            return state.instructionData;
        },
        getTransactionCode(state) {
            return state.instructionData.transaction_code;
        },
        getCostData: (state) => (index) => {
            return state.instructionData.cost_detail[index];
        },
        getAttachmentList(state) {
            return state.instructionData.attachment;
        },
        getNotes(state) {
            return state.instructionData.notes;
        },
        getUsdTotal(state) {
            const vat_amount = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "USD") {
                        return a + b.vat_amount;
                    } else {
                        return a;
                    }
                },
                0
            );
            const sub_total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "USD") {
                        return a + b.sub_total;
                    } else {
                        return a;
                    }
                },
                0
            );
            const total = state.instructionData.cost_detail.reduce(function (
                a,
                b
            ) {
                if (b.currency === "USD") {
                    return a + b.total;
                } else {
                    return a;
                }
            },
            0);

            return {
                vat_amount,
                sub_total,
                total,
            };
        },
        getAudTotal(state) {
            const vat_amount = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "AUD") {
                        return a + b.vat_amount;
                    } else {
                        return a;
                    }
                },
                0
            );
            const sub_total = state.instructionData.cost_detail.reduce(
                function (a, b) {
                    if (b.currency === "AUD") {
                        return a + b.sub_total;
                    } else {
                        return a;
                    }
                },
                0
            );
            const total = state.instructionData.cost_detail.reduce(function (
                a,
                b
            ) {
                if (b.currency === "AUD") {
                    return a + b.total;
                } else {
                    return a;
                }
            },
            0);

            return {
                vat_amount,
                sub_total,
                total,
                data: state.instructionData.cost_detail,
            };
        },
        UsdCheck(state) {
            return state.instructionData.cost_detail.some(function (cost) {
                return cost.currency === "USD";
            });
        },
        AudCheck(state) {
            return state.instructionData.cost_detail.some(function (cost) {
                return cost.currency === "AUD";
            });
        },
        getVendorInvoiceAll(state) {
            return state.instructionData.invoices;
        },
        getVendorInvoice: (state) => (index) => {
            return state.instructionData.invoices[index];
        },
        getAttachmentInternalOnly(state) {
            return state.internalOnly.attachment;
        },
        getNotesInternalOnlyAll(state) {
            return state.internalOnly.notes;
        },
        getNotesInternalOnly: (state) => (index) => {
            return state.internalOnly.notes[index].value;
        },
        getTermination(state) {
            return state.termination;
        },
        getFormData(state) {
            return state.formData;
        },
    },
    mutations: {
        reset(state) {
            state.instructionData = JSON.parse(JSON.stringify(INITIAL_STATE))
        },

        // update instruction
        updateInstruction(state, payload) {
            state.instructionData = payload;
        },
        updateInstructionId(state, payload) {
            state.instructionData.instruction_id = payload;
        },
        updateStatus(state, payload) {
            state.instructionData.instruction_status = payload;
        },
        updateInstructionType(state, payload) {
            state.instructionData.instruction_type = payload;
        },
        updateAssignedVendor(state, payload) {
            state.instructionData.assigned_vendor = payload;
        },
        updateVendorAddress(state, payload) {
            state.instructionData.vendor_address = payload;
        },
        updateAttentionOf(state, payload) {
            state.instructionData.attention_of = payload;
        },
        updateQuotationNumber(state, payload) {
            state.instructionData.quotation_number = parseInt(payload);
        },
        updateInvoiceTo(state, payload) {
            state.instructionData.invoice_to = payload;
        },
        updateCustomerContract(state, payload) {
            state.instructionData.customer_contact = payload;
        },
        updatePoNumber(state, payload) {
            state.instructionData.cust_po_number = payload;
        },
        updateNotes(state, payload) {
            state.instructionData.notes = payload;
        },

        // cost list
        addCostList(state) {
            state.instructionData.cost_detail.push({
                cost_description: "",
                quantity: 0,
                unit_of_measurement: "SHP",
                unit_price: 0,
                GST_percentage: 0,
                currency: "",
                vat_amount: 0,
                sub_total: 0,
                total: 0,
                charge_to: "",
            });
        },
        deleteCostList(state, i) {
            state.instructionData.cost_detail.splice(i, 1);
        },
        updateCostDescription(state, payload) {
            state.instructionData.cost_detail[payload.i].cost_description =
                payload.data;
        },
        updateCostQuantity(state, payload) {
            state.instructionData.cost_detail[payload.i].quantity = parseInt(
                payload.data
            );
            this.commit("updateCostTotal", payload.i);
        },
        updateCostUOM(state, payload) {
            state.instructionData.cost_detail[payload.i].unit_of_measurement =
                payload.data;
        },
        updateCostUnitPrice(state, payload) {
            state.instructionData.cost_detail[payload.i].unit_price =
                parseFloat(payload.data);
            this.commit("updateCostTotal", payload.i);
        },
        updateCostGST(state, payload) {
            state.instructionData.cost_detail[payload.i].GST_percentage =
                parseFloat(payload.data);
            this.commit("updateCostTotal", payload.i);
        },
        updateCostCurrency(state, payload) {
            state.instructionData.cost_detail[payload.i].currency =
                payload.data;
        },
        updateCostChargeTo(state, payload) {
            state.instructionData.cost_detail[payload.i].charge_to =
                payload.data;
        },
        updateCostTotal(state, i) {
            const data = state.instructionData.cost_detail[i];
            data.vat_amount =
                Math.round(
                    ((data.unit_price * data.quantity * data.GST_percentage) /
                        100) *
                        100
                ) / 100;
            data.sub_total =
                Math.round(data.unit_price * data.quantity * 100) / 100;
            data.total =
                Math.round((data.vat_amount + data.sub_total) * 100) / 100;
        },

        // attachment instruction
        addAttachment(state, payload) {
            state.instructionData.attachment.push(payload);
        },
        deleteAttachment(state, i) {
            state.instructionData.attachment.splice(i, 1);
        },

        // link to
        updateLinkTo(state, payload) {
            state.instructionData.transaction_code = payload;
        },
        removeLinkTo(state) {
            state.instructionData.transaction_code = "";
        },

        // invoice
        addInvoices(state, payload) {
            state.instructionData.invoices.push(payload);
        },
        deleteInvoice(state, i) {
            state.instructionData.invoices.splice(i, 1);
        },
        updateInvoice(state, payload) {
            state.instructionData.invoices[payload.index] = payload.invoice;
            console.log("edit invoice");
        },

        // attachment internal only
        addAttachmentInternalOnly(state, payload) {
            state.internalOnly.attachment.push(payload);
        },
        deleteAttachmentInternalOnly(state, i) {
            state.internalOnly.attachment.splice(i, 1);
        },

        // notes internal only
        addNotesInternalOnly(state, payload) {
            state.internalOnly.notes.push(payload);
        },
        deleteNotesInternalOnly(state, i) {
            state.internalOnly.notes.splice(i, 1);
        },
        updateNotesInternalOnly(state, payload) {
            state.internalOnly.notes[payload.index] = payload.data;
        },

        // termination
        updateDescriptionTermination(state, payload) {
            state.termination.termination_reason = payload
        },
        addAttachmentTerminate(state, payload) {
            state.termination.attachment.push(payload);
        },
        deleteAttachmentTerminate(state, i) {
            state.termination.attachment.splice(i, 1);
        },

        setFormData(state, payload) {
            state.formData = payload;
        },
    },
    actions: {
        async getFormData(context) {
            const data = (
                await axios.get("http://127.0.0.1:8000/api/instruction/addNew")
            ).data;
            context.commit("setFormData", await data.form_data);
            console.log(data);
        },
        deleteAttachmentInstruction(context, i) {
            const file = context.state.instructionData.attachment[i].download;
            axios
                .delete(
                    `http://127.0.0.1:8000/api/instruction/deleteFile/${file}`
                )
                .then(() => {
                    context.commit("deleteAttachment", i);
                });
        },
        submitInstruction(context) {
            context.commit("updateStatus", "In Progress");
            const { instruction_id, ...other } = context.state.instructionData;
            console.log(other);
            axios
                .post("/api/instruction/add", other)
                .then((json) => {
                    context.commit('updateInstructionId', json.data.instruction.instruction_id)
                })
                .catch((err) => console.log(err));
        },
        saveAsDraft(context) {
            context.commit("updateStatus", "Draft");
            const { instruction_id, ...other } = context.state.instructionData;
            console.log(other);
            axios
                .post("/api/instruction/add", other)
                .then((data) => console.log(data))
                .catch((err) => console.log(err));
        },
        detailInstruction(context, id) {
            axios.get("/api/instruction/" + id).then((json) => {
                const { _id, ...other } = json.data.detail_instruction;
                context.commit("updateInstruction", other);
                console.log(this.state.instructionData);
            });
        },
        addAttachmentInDetail(context, payload) {
            const data = {
                instruction_id: context.getters.getId,
                attachment: payload
            }
            axios.put('/api/instruction/addAttachment', data)
            .then(()=>context.dispatch('refresh'))
        },
        editInstruction(context) {
            axios
                .put(
                    "/api/instruction/update",
                    context.getters.getInstructionDetail
                )
                .then((json) => console.log(json.data));
        },
        addInvoices(context, payload) {
            const data = {
                instruction_id: context.state.instructionData.instruction_id,
                ...payload,
            };
            axios.put("/api/instruction/addInvoice", data)
            .then(() => {
                context.commit("addInvoices", data);
            });
        },
        deleteInvoice(context, index) {
            axios.put('/api/instruction/deleteInvoice', {
                instruction_id: context.state.instructionData.instruction_id,
                index
            }).then(()=>{
                context.commit('deleteInvoice', index)
            })
        },
        updateInvoice(context, {invoice, index}) {
            const data = {
                instruction_id: context.state.instructionData.instruction_id,
                index,
                ...invoice
            }
            axios.put('/api/instruction/updateInvoice', data)
            .then(()=>{
                context.commit('updateInvoice', {index, invoice})
            })
        },
        refresh(context) {
            axios.get("/api/instruction/" + context.state.instructionData.instruction_id)
            .then((json) => {
                const { _id, ...other } = json.data.detail_instruction;
                context.commit("updateInstruction", other);
                console.log(this.state.instructionData);
            });

        },
        isCompleted(context) {
            axios.put('/api/instruction/completed/'+ context.state.instructionData.instruction_id)
            .then(()=>context.commit('updateStatus', 'Completed'))
        },
        terminate(context) {
            const data = {
                instruction_id: context.state.instructionData.instruction_id,
                ...context.getters.getTermination
            }
            console.log(data);
            axios.put('/api/instruction/addTermination', data)
            .then(()=>{
                console.log('berhasil addTerminate');
                axios.put('/api/instruction/terminate/'+ context.state.instructionData.instruction_id)
                .then(()=>{
                    console.log('berhasil terminate')
                    context.dispatch('refresh')
                })
            })
        }
    },
});

export default store;
