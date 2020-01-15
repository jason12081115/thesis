export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer'
    },
    {
      title: true,
      name: 'Master File'
    },
    {
      name: 'Students',
      url: '/students',
      icon: 'fa fa-users',
      children: [
        {
          name: 'Student Lists',
          url: '/students/StudentLists',
          icon: 'fa fa-user-o'
        },
        // {
        //   name: '2nd Year',
        //   url: '/studentlists/Secondyear',
        //   icon: 'fa fa-user-o'
        // },
        // {
        //   name: '3rd Year',
        //   url: '/studentlists/Thirdyear',
        //   icon: 'fa fa-user-o'
        // },
        // {
        //   name: '4th Year',
        //   url: '/studentlists/Fourthyear',
        //   icon: 'fa fa-user-o'
        //   // icon: 'fa fa-user-o fa-lg mt-4'
        // },
      ]
    },
    {
      name: 'References',
      url: '/references',
      icon: 'fa fa-folder-open',
      children: [
           {
             name: 'Subject',
             url: '/references/subjects',
             icon: 'fa fa-book'
           },
      ]
    },
    {
      name: 'Curriculum',
      url: '/curriculum',
      icon: 'icon-book-open',
      children: [
           {
             name: 'Curriculum Year',
             url: '/curriculum/CurriculumYears',
             icon: 'fa fa-book'
           },
           {
            name: 'Curriculum List',
            url: '/curriculum/CurriculumLists',
            icon: 'fa fa-list'
          },
          ]
        },
        {
          name: 'Evaluation',
          url: '/evaluation',
          icon: 'icon-pie-chart',
          children: [
               {
                 name: 'Student Evaluation',
                 url: '/evaluation/StudentEvaluations',
                 icon: 'fa fa-user-o'
               },
              ]
            },
      
             {
              divider: true
            },
            {
              title: true,
              name: 'Extras'
            },
            {
              name: 'Settings',
              url: '/settings',
              icon: 'fa fa-gear',
              children: [
                {
                  name: 'Profile',
                  url: '/settings/profile',
                  icon: 'fa fa-user'
                },
                {
                  name: 'User Account',
                  url: '/settings/profile',
                  icon: 'fa fa-user'
                },
              ]
            },
  ],
}
