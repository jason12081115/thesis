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
                                Subject List
                                <!-- <small class="font-italic">List of all registered categoty.</small> -->
                                </span>
                        </h5>
                        
                        <b-row class="mb-2"> <!-- row button and search input -->
                            <b-col sm="4">
                                <b-button variant="primary" @click="showModalEntry = true, entryMode='Add', clearFields('subject')">
                                        <i class="fa fa-plus-circle"></i> Add New Subject
                                </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-form-input 
                                    v-model="filters.subjects.criteria"
                                    type="text" 
                                    placeholder="Search">
                                </b-form-input>
                            </b-col>
                        </b-row> <!-- row button and search input -->
                    
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                    :filter="filters.subjects.criteria"
                                    :fields="tables.subjects.fields"
                                    :items.sync="tables.subjects.items"
                                    :current-page="paginations.subjects.currentPage"
                                    :per-page="paginations.subjects.perPage"
                                > <!-- table -->

                                <template v-slot:cell(action)="data" > <!-- action slot  :to="{path: 'subjects/' + data.item.id } v-slot:cell(action)="data"-->
                                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                                        <i class="fa fa-edit"></i>
                                    </b-btn>

                                    <b-btn :size="'sm'" :disabled="forms.subject.isDeleting" variant="danger" @click="setDelete(data)">
                                        <icon v-if="forms.subject.isDeleting" name="sync" spin></icon>
                                        <i v-else class="fa fa-trash"></i>
                                    </b-btn>
                                </template>

                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->

                        <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.subjects.totalRows" :per-page="paginations.subjects.perPage" v-model="paginations.subjects.currentPage"
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
                @shown="focusElement('subject_code')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Subject Entry - {{entryMode}}
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('subject')" autocomplete="off">
                    <b-form-group>
                        <label for="subject_code">* Subject Code</label>
                        <b-form-input
                            id="subject_code"
                            v-model="forms.subject.fields.subject_code"
                            type="text"
                            placeholder="Subject Code"
                            ref="subject_code">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                    <label for="subject_description">* Subject Description.</label>
                    <b-form-input
                      id="subject_description"
                      v-model="forms.subject.fields.subject_description"
                      type="text"
                      placeholder="Subject Description"
                      ref="subject_description"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                    <label for="subject_unit">* Unit</label>
                    <b-form-input
                      ref="subject_unit"
                      id="subject_unit"
                      v-model="forms.subject.fields.subject_unit"
                      type="text"
                      placeholder="Unit"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                        <label for="subject_prerequisite_id">* Select Subjects Prerequisite.</label>
                        <select2
                          ref="subject_prerequisite_id"
                          :allowClear="false"
                          :placeholder="'Select Subjects Prerequisite.'"
                          v-model="forms.subject.fields.subject_prerequisite_id"
                        >
                          <option
                            v-for="sub in options.subjects.items"
                            :key="sub.subject_code"
                            :value="sub.subject_code"
                          >{{sub.subject_code}}</option>
                        </select2>
                      </b-form-group>
                  <!-- <b-form-group>
                    <label for="subject_prerequisite_id">* Subjects Prerequisite</label>
                    <b-form-input
                      ref="subject_prerequisite_id"
                      id="subject_prerequisite_id"
                      v-model="forms.subject.fields.subject_prerequisite_id"
                      type="text"
                      placeholder="Subjects Prerequisite"
                    ></b-form-input>
                  </b-form-group> -->
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.subject.isSaving" variant="primary" @click="onSubjectEntry">
                    <icon v-if="forms.subject.isSaving" name="sync" spin></icon>
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
                    Delete subject
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this subject?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.subject.isSaving" variant="primary" @click="onSubjectDelete">
                        <icon v-if="forms.subject.isSaving" name="sync" spin></icon>
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
    name: 'subjects',
    data () {
      return {
        entryMode: 'Add',
        showModalEntry: false, //if true show modal
        showModalDelete: false,
        forms:{
            subject : {
                isSaving: false,
                isDeleting: false,
                fields: {
                    subjects_id: null,
                    subject_code: null,
                    subject_description: null,
                    subject_unit: null,
                    subject_prerequisite_id: null,
                    sort_key: 0
                }
            }
        },
        tables: {
            subjects: {
                fields: [
            {
              key: "subject_code",
              label: "Subject Code",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "subject_description",
              label: "Subject Description",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "subject_unit",
              label: "Unit",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "subject_prerequisite_id",
              label: "Prerequisite",
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
          subjects: {
            criteria: null
          }
        },
        paginations: {
          subjects: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        options: {
        subjects: {
          items: []
        }
      },
        subject_id: null,
        row: []
      }
    },
    methods:{
        onSubjectEntry () {
            if(this.entryMode == 'Add'){
                this.createEntity('subject', true, 'subjects')
            }
            else{
                this.updateEntity('subject', 'subject_id', true, this.row)
            }
        },
        onSubjectDelete(){
            this.deleteEntity('subject', this.subject_id, true, 'subjects', 'subject_id')
        },
        async setDelete(data){
            if(await this.checkIfUsed('subject', data.item.subject_id) == true){
                // this.$notify({
                //     type: 'error',
                //     group: 'notification',
                //     title: 'Error!',
                //     text: "Unable to delete, this record is being used by other transactions."
                // })
                return
            }
            this.subject_id = data.item.subject_id
            this.showModalDelete = true
        },
        setUpdate(data){
            this.row = data.item
            this.resetFieldStates('subject')
            this.fillEntityForm('subject', data.item.subject_id)
            this.showModalEntry=true
            this.entryMode='Edit'
        }
    },
    created () {
      this.fillTableList('subjects')
      this.fillOptionsList('subjects')

    // this.$http.get('api/subjects', {
    //     headers: {
    //         Authorization: 'Bearer ' + localStorage.getItem('token')
    //     }
    // }).then(response => {
    //     this.tables.subjects.items = response.data.subjects
    //     this.paginations.subjects.totalRows = response.data.adjustmentlists
    //     this.options.subject.items = response.data.subject
    // }).catch(error => {
    //     console.log(error)
    // })
  },
  }
</script>

