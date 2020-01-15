<template>
  <div>
    <!-- main container -->
    <notifications group="notification" />
    <div v-show="!showEntry" class="animated fadeIn">
      <!-- main div -->
      <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card>
            <!-- main card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Curriculum List
              </span>
            </h5>

            <!-- row button and search input -->

            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showEntry = true, entryMode='Add', clearFields('curriculum'), tables.curriculumitems.items=[], forms.curriculum.fields.receiving_datetime = new Date()"
                 
                >
                  <i class="fa fa-plus-circle"></i> Create New Curriculum
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input
                  v-model="filters.curriculums.criteria"
                  type="text"
                  placeholder="Search"
                ></b-form-input>
              </b-col>
            </b-row>
            <!-- row button and search input -->

            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  responsive
                  fixed
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :filter="filters.curriculums.criteria"
                  :fields="tables.curriculums.fields"
                  style
                  :items.sync="tables.curriculums.items"
                  :current-page="paginations.curriculums.currentPage"
                  :per-page="paginations.curriculums.perPage"
                >
                  <!-- table -->

                  <template v-slot:cell(action)="data">
                    <!-- action slot  :to="{path: 'curriculums/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.curriculum.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.curriculum.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->

            <b-row>
              <!-- Pagination -->
              <b-col sm="12" class="my-1">
                <b-pagination
                  size="sm"
                  align="right"
                  :total-rows="paginations.curriculums.totalRows"
                  :per-page="paginations.curriculums.perPage"
                  v-model="paginations.curriculums.currentPage"
                  class="my-0"
                />
              </b-col>
            </b-row>
            <!-- Pagination -->
          </b-card>
          <!-- main card -->
        </b-col>
      </b-row>
      <!-- main row -->
    </div>
    <!-- main div -->

    <div v-show="showEntry" class="animated fadeIn">
      <!-- sec div -->
      <b-row>
        <!-- sec row -->
        <b-col sm="12">
          <b-card>
            <!-- sec card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">Curriculum List Entry - {{entryMode}}</span>
            </h5>
            <div class="scroll">
              <b-col lg="12">
                <!-- modal body -->
                <b-form autocomplete="off">
                  <b-row>
                    <b-col lg="4">
                      <!-- divider -->
                      <b-form-group>
                        <label for="curriculum_year_id">* Select Curriculum Year.</label>
                        <select2
                          ref="curriculum_year_id"
                          :allowClear="false"
                          :placeholder="'Select Curriculum Year.'"
                          v-model="forms.curriculum.fields.curriculum_year_id"
                        >
                          <option
                            v-for="pur in options.curr_years.items"
                            :key="pur.curriculum_year_id"
                            :value="pur.curriculum_year_id"
                          >{{pur.curriculum_year}}</option>
                        </select2>
                      </b-form-group>
                    </b-col>
                    <b-col lg=4>
                    </b-col>
                     <b-col lg=2>
                               <b-form-group>
                        <label>Year</label>
                        <b-form-input
                          id="contact_num"
                          v-model="forms.curriculum.fields.contact_num"
                          type="text"
                          placeholder="Year"
                          ref="contact_num"
                        ></b-form-input>
                      </b-form-group>
                      </b-col>
                            <b-col lg=2>
                      <b-form-group>
                        <label>Sem</label>
                        <b-form-input
                          id="email_address"
                          v-model="forms.curriculum.fields.email_address"
                          type="text"
                          placeholder="Sem"
                          ref="email_address"
                        ></b-form-input>
                      </b-form-group>
                    </b-col>
                  </b-row>
                </b-form>
              </b-col>
              <!-- modal body -->
            </div>
            <br>
                  <b-row class="mb-2">
                    <b-col lg=4>
                        <b-button variant="primary" @click="showModalSubjects = true, selectedRow=[]">
                            <i class="fa fa-plus-circle"></i> Add Subjects
                        </b-button>
                    </b-col>
                    <b-col lg=4></b-col>
                    <b-col lg=4>
                        <b-form-input v-model="filters.curriculumitems.criteria" placeholder="Search"></b-form-input>
                    </b-col>
                </b-row>
            <div>
              <!-- row table -->
              <b-row>
                <b-col sm="12">
                  <b-table
                    responsive
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.curriculumitems.criteria"
                    :fields="tables.curriculumitems.fields"
                    style
                    :items.sync="tables.curriculumitems.items"
                  
                  >
                    <!-- table -->
                    <template v-slot:cell(action)="data">
                                <b-btn
                                    :size="'sm'"
                                    variant="danger"
                                    @click="removeSubject(data.index)"
                                >
                                    <i class="fa fa-trash"></i>
                                </b-btn>
                            </template>
                        </b-table>
                  <!-- table -->
                  <b-row>   
                        </b-row>
                </b-col>
              </b-row>
            </div>
            

            <div slot="footer"  class="pull-right mt-2">
              <!-- modal footer buttons -->
              <b-button
                :disabled="forms.curriculum.isSaving"
                variant="primary"
                @click="onCurriculumsEntry"
              >
                <icon v-if="forms.curriculum.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
              </b-button>
              <b-button variant="secondary" @click="showEntry=false">Close</b-button>
            </div>
            <!-- modal footer buttons -->
          </b-card>
          <!-- sec card -->
        </b-col>
      </b-row>
      <!-- sec row -->
    </div>
    <!-- sec div -->

    <div>
      <!-- modal div -->
<div>
              <!-- modal div -->
              <b-modal
                size="lg"
                v-model="showModalSubjects"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                :scrollable="true"
                
              >
                <div slot="modal-title">
                  <!-- modal title -->
                  Subject List
                </div>
                <!-- modal title -->

                <b-row class="mb-2">
                  <!-- row button and search input -->
                  <b-col sm="4"></b-col>

                  <b-col sm="4">
                    <span></span>
                  </b-col>

                  <b-col sm="4">
                     <b-form-input
                    v-model="filters.subjects.criteria"
                    type="text"
                    placeholder="Search"
                ></b-form-input>
                  </b-col>
                </b-row>
                <!-- row button and search input -->

                <b-col sm="12">
                  <b-table
                    :scrollable="true"
                    responsive
                    selectable
                    select-mode="single"
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.subjects.criteria"
                    :fields="tables.subjects.fields"
                    style
                    :items.sync="tables.subjects.items"
                    :current-page="paginations.subjects.currentPage"
                    :per-page="paginations.subjects.perPage"
                    @filtered="onFiltered($event, 'subjects')"
                    @row-selected="selectedRow = $event"
                  >
                    <!-- table -->
                  </b-table>
                </b-col>
                <!-- modal body -->
                <div></div>

                <b-row>
                            <!-- Pagination -->
                            <b-col sm="12" class="my-1">
                                <b-pagination
                                size="sm"
                                align="right"
                                :total-rows="paginations.subjects.totalRows"
                                :per-page="paginations.subjects.perPage"
                                v-model="paginations.subjects.currentPage"
                                class="my-0"
                                />
                            </b-col>
                            </b-row>
                            <!-- Pagination -->

                <div slot="modal-footer">
                  <!-- modal footer buttons -->
                  <b-button
                    variant="primary"
                    @click="rowSelected"
                  >
                    <icon v-if="forms.curriculum.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Accept
                  </b-button>
                  <b-button variant="secondary" @click="showModalSubjects=false">Close</b-button>
                </div>
                <!-- modal footer buttons -->
              </b-modal>
            </div>
      <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title">Delete Subject</div>
        <b-col lg="12">Are you sure you want to delete this?</b-col>
        <div slot="modal-footer">
          <b-button
            :disabled="forms.curriculum.isSaving"
            variant="primary"
            @click="oncurriculumsDelete"
          >
            <icon v-if="forms.curriculum.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            OK
          </b-button>
          <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
        </div>
      </b-modal>
    </div>
    <!-- modal div -->
  </div>
  <!-- main container -->
</template>

<script>
export default {
  name: "curriculums",
  data() {
    return {
      selectedRow: [],
      entryMode: "Add",
      showEntry: false, //if true show modal
      showModalSubjects: false,
      showModalDelete: false,
      showNationality: false,
      showModalIdType: false,
      forms: {
        curriculum: {
          isSaving: false,
          isDeleting: false,
          fields: {
            curriculum_list_id: null,
            curriculum_year: null,
            curriculum_year_id: null,
            subject_id: null,
          }
        }
      },
      tables: {
        curriculums: {
          fields: [
            {
              key: "curriculum_year",
              label: "Curriculum Year",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
        curriculumitems: {
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
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
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
          ],
          items: []
        }
      },
      filters: {
        curriculums: {
          criteria: null
        },
         curriculumitems: {
          criteria: null
        },
        subjects: {
          criteria: null
        },
      },
      paginations: {
        curriculums: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
            curriculumitems: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
            subjects: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
        },
      options: {
        curr_years: {
          items: []
        }
      },
      curriculum_list_id: null,
      row: []
    };
  },
  methods: {
    onCurriculumsEntry() {
      if(this.tables.curriculumitems.items.length > 0) {
        this.forms.curriculum.fields.items = this.tables.curriculumitems.items
        if (this.entryMode == "Add") {
          this.createEntity("curriculum", false, "curriculums");
        } else {
          this.updateEntity(
            "curriculum",
            "curriculum_list_id",
            false,
            this.row
          );
        }
      }
      else {
        this.$notify({
          type: 'error',
          group: 'notification',
          title: 'Error!',
          text: 'Please Add an Subject'
        })
      }
    },
    oncurriculumsDelete() {
      this.deleteEntity(
        "curriculum",
        this.curriculum_list_id,
        true,
        "curriculums",
        "curriculum_list_id"
      );
    },
    onSubjectlistDelete() {
      this.deleteEntity(
        "Subjectlist",
        this.subject_id,
        true,
        "Subjectlist",
        "subject_id"
      );
    },
    async setDelete(data) {
      if (
        (await this.checkIfUsed(
          "curriculum",
          data.item.curriculum_list_id
        )) == true
      ) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.curriculum_list_id = data.item.curriculum_list_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.$http.get('api/curriculum/'+ data.item.curriculum_list_id, {
          headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
          }
      }).then(response => {
          this.forms.curriculum.fields = response.data.curriculums
          this.tables.curriculumitems.items = response.data.curriculumitems
          this.showEntry = true
          this.entryMode = "Edit"
      }).catch(err => {
          console.log(err)
      })
    },
    rowSelected() {
      if(this.selectedRow.length > 0){
        if(this.tables.curriculumitems.items.filter(i => i.subject_id == this.selectedRow[0].subject_id).length > 0){
           this.$notify({
                    type: "error",
                    group: "notification",
                    title: "Error!",
                    text: "Subject is already added."
                })
                return
            }
           this.tables.curriculumitems.items.push({
                subject_id: this.selectedRow[0].subject_id,
                subject_code: this.selectedRow[0].subject_code,
                subject_description: this.selectedRow[0].subject_description,
                subject_unit: this.selectedRow[0].subject_unit,
                subject_prerequisite_id: this.selectedRow[0].subject_prerequisite_id,
           })
        }
  },
  removeSubject(index){
        this.tables.curriculumitems.items.splice(index, 1)
    }
  },
  created() {
  this.$http.get('api/curriculums', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then(response => {
        this.tables.curriculums.items = response.data.curriculums
        this.paginations.curriculums.totalRows = response.data.curriculums.length
        this.tables.subjects.items = response.data.subjects
        this.paginations.subjects.totalRows = response.data.subjects.length
        this.options.curr_years.items = response.data.curr_years
    }).catch(error => {
        console.log(error)
    })
  },
};
</script>

