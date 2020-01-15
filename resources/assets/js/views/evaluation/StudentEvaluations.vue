<template>
  <div>
    <!-- main container -->
    <notifications group="notification" />
    <div class="animated fadeIn">
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
                Student List
                <!-- <small class="font-italic">List of all registered categoty.</small> -->
              </span>
            </h5>

            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <!-- <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('student')"
                >
                  <i class="fa fa-plus-circle"></i> Add New Student
                </b-button> -->
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input v-model="filters.students.criteria" type="text" placeholder="Search"></b-form-input>
              </b-col>
            </b-row>
            <!-- row button and search input -->

            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  responsive
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :filter="filters.students.criteria"
                  :fields="tables.students.fields"
                  :items.sync="tables.students.items"
                  :current-page="paginations.students.currentPage"
                  :per-page="paginations.students.perPage"
                >
                  <!-- table -->

                  <template v-slot:cell(action)="data">
                    <!-- action slot  :to="{path: 'students/' + data.item.id } v-slot:cell(action)="data"-->
                    <!-- <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn> -->
                    <b-button :size="'sm'" variant="primary" @click="showAddgrade = true">
              Advise</b-button>
                

                    <!-- <b-btn
                      :size="'sm'"
                      :disabled="forms.student.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.student.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn> -->
                     <b-button :size="'sm'" variant="success">
                   Evaluate</b-button>
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
                  :total-rows="paginations.students.totalRows"
                  :per-page="paginations.students.perPage"
                  v-model="paginations.students.currentPage"
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

  </div>
  <!-- main container -->
</template>

<script>
export default {
  name: "students",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false, //if true show modal
      showModalDelete: false,
      forms: {
        student: {
          isSaving: false,
          isDeleting: false,
          fields: {
            student_no: null,
            student_year: null,
            last_name: null,
            first_name: null,
            middle_name: null,
            student_address: null,
            student_contact: null,
            student_gender: 0,
            sort_key: 0
          }
        }
      },
      tables: {
        students: {
          fields: [
            {
              key: "student_no",
              label: "Student No.",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "student_year",
              label: "Student Year.",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "first_name",
              label: "First Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "last_name",
              label: "Last Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "middle_name",
              label: "Middle Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "student_gender",
              label: "Gender",
              tdClass: "align-middle",
              sortable: true,
              formatter: (value) => {
                  if(value == 0 && value == '0'){
                    return 'Male'
                  }
                  return 'Female'
              }
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "150px" },
              tdClass: "text-center"
            }
          ],
          items: []
        }
      },
      filters: {
        students: {
          criteria: null
        }
      },
      paginations: {
        students: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      student_id: null,
      row: []
    };
  },
  methods: {
    onstudentEntry() {
      if (this.entryMode == "Add") {
        this.createEntity("student", true, "students");
      } else {
        this.updateEntity("student", "student_id", true, this.row);
      }
    },
    onstudentDelete() {
      this.deleteEntity(
        "student",
        this.student_id,
        true,
        "students",
        "student_id"
      );
    },
    async setDelete(data) {
      if ((await this.checkIfUsed("student", data.item.student_id)) == true) {
        // this.$notify({
        //     type: 'error',
        //     group: 'notification',
        //     title: 'Error!',
        //     text: "Unable to delete, this record is being used by other transactions."
        // })
        return;
      }
      this.student_id = data.item.student_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("student");
      this.fillEntityForm("student", data.item.student_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    this.fillTableList("students");
  }
};
</script>

