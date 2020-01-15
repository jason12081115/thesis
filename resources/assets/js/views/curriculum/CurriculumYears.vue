<template>
    <div><!-- main container -->
        <notifications group="notification" />
        <div class="animated fadeIn"> <!-- main div -->
            <b-row> <!-- main row -->
                <b-col sm="12">
                    <b-card > <!-- main card -->
                        <h5 slot="header">  <!-- table header -->
                            <span class="text-primary">
                                <i class="fa fa-bars"></i> 
                                Curriculum Year List
                                <!-- <small class="font-italic">List of all registered categoty.</small> -->
                                </span>
                        </h5>
                        
                        <b-row class="mb-2"> <!-- row button and search input -->
                            <b-col sm="4">
                                <b-button variant="primary" @click="showModalEntry = true, entryMode='Add', clearFields('curr')">
                                        <i class="fa fa-plus-circle"></i> Add New Curriculum Year
                                </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-form-input 
                                    v-model="filters.curr_years.criteria"
                                    type="text" 
                                    placeholder="Search">
                                </b-form-input>
                            </b-col>
                        </b-row> <!-- row button and search input -->
                    
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                    :filter="filters.curr_years.criteria"
                                    :fields="tables.curr_years.fields"
                                    :items.sync="tables.curr_years.items"
                                    :current-page="paginations.curr_years.currentPage"
                                    :per-page="paginations.curr_years.perPage"
                                > <!-- table -->

                                <template v-slot:cell(action)="data" > <!-- action slot  :to="{path: 'curr_years/' + data.item.id } v-slot:cell(action)="data"-->
                                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                                        <i class="fa fa-edit"></i>
                                    </b-btn>

                                    <b-btn :size="'sm'" :disabled="forms.curr.isDeleting" variant="danger" @click="setDelete(data)">
                                        <icon v-if="forms.curr.isDeleting" name="sync" spin></icon>
                                        <i v-else class="fa fa-trash"></i>
                                    </b-btn>
                                </template>

                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->

                        <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.curr_years.totalRows" :per-page="paginations.curr_years.perPage" v-model="paginations.curr_years.currentPage"
                                     class="my-0" />
                                </b-col>
                        </b-row> <!-- Pagination -->
                        
                    </b-card><!-- main card -->
                </b-col>
            </b-row> <!-- main row -->

        </div><!-- main div -->

        <div> <!-- modal div -->
            <b-modal 
                v-model="showModalEntry"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('curriculum_year')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Curriculum Year Entry - {{entryMode}}
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('curr')" autocomplete="off">
                    <b-form-group>
                    <label>* Curriculum Year</label>
                    <b-form-input
                      v-model="forms.curr.fields.curriculum_year"
                      ref="curriculum_year"
                      id="curriculum_year"
                      type="number"
                      class="form-control"
                    >></b-form-input>
                  </b-form-group>
                    <b-form-group>
                        <label>Curriculum Description</label>
                        <b-form-input
                            ref="curriculum_desc"
                            id="curriculum_desc"
                            v-model="forms.curr.fields.curriculum_desc"
                            type="text"
                            placeholder="Curriculum Description">
                        </b-form-input>
                    </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.curr.isSaving" variant="primary" @click="oncurrEntry">
                    <icon v-if="forms.curr.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
            </div> <!-- modal footer buttons -->

            </b-modal>
            <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete curr
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this curr?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.curr.isSaving" variant="primary" @click="oncurrDelete">
                        <icon v-if="forms.curr.isSaving" name="sync" spin></icon>
                        <i class="fa fa-check"></i>
                        OK
                    </b-button>
                    <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>            
                </div>
            </b-modal>
        </div> <!-- modal div -->

    </div> <!-- main container -->

   
</template>

<script>
export default {
    name: 'curr_years',
    data () {
      return {
        entryMode: 'Add',
        showModalEntry: false, //if true show modal
        showModalDelete: false,
        forms:{
            curr : {
                isSaving: false,
                isDeleting: false,
                fields: {
                    curr_years_id: null,
                    curriculum_year: null,
                    curr_description: null,
                    curr_unit: null,
                    curr_prerequisite_id: null,
                    sort_key: 0
                }
            }
        },
        tables: {
            curr_years: {
                fields: [
                {
              key: "curriculum_year",
              label: "Curriculum Year",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "curriculum_desc",
              label: "Curriculum Description",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {   
              key: 'action',
              label: '',
              thStyle: {width: '80px'},
              tdClass: 'text-center'
            },
                ],
                items: []
            }
        },
        filters: {
          curr_years: {
            criteria: null
          }
        },
        paginations: {
          curr_years: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        curriculum_year_id: null,
        row: []
      }
    },
    methods:{
        oncurrEntry () {
            if(this.entryMode == 'Add'){
                this.createEntity('curr', true, 'curr_years')
            }
            else{
                this.updateEntity('curr', 'curriculum_year_id', true, this.row)
            }
        },
        oncurrDelete(){
            this.deleteEntity('curr', this.curriculum_year_id, true, 'curr_years', 'curriculum_year_id')
        },
        async setDelete(data){
            if(await this.checkIfUsed('curr', data.item.curriculum_year_id) == true){
                // this.$notify({
                //     type: 'error',
                //     group: 'notification',
                //     title: 'Error!',
                //     text: "Unable to delete, this record is being used by other transactions."
                // })
                return
            }
            this.curriculum_year_id = data.item.curriculum_year_id
            this.showModalDelete = true
        },
        setUpdate(data){
            this.row = data.item
            this.resetFieldStates('curr')
            this.fillEntityForm('curr', data.item.curriculum_year_id)
            this.showModalEntry=true
            this.entryMode='Edit'
        }
    },
    created () {
      this.fillTableList('curr_years')
    }
  }
</script>

