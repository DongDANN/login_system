console.log("validation.js loaded successfully");

const validation = new JustValidate('#signup');

validation
  .addField('#name', [
    {
      rule: 'required',
    }
])
  .addField('#email', [
    {
      rule: 'required',
    },
    {
      rule: 'email',
    },
    {
      validator: (value) => () => {
        return fetch("validate-email.php?email=" + encodeURIComponent(value))
              .then(function(response) {
                return response.json();
              })
              .then(function(json){
                return json.available;
              });
      },
      errorMessage: 'Email is already taken'
    }
  ])
  .addField('#password', [
    {
      rule: 'required',
    },
    {
      rule: 'password',
    },
  ])
  .addField('#password_confirmation', [
    {
      rule: 'required',
    },
    {
      validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
          const repeatPasswordValue = fields['#password'].elem.value;
          return value === repeatPasswordValue;
        }
        return false;
      },
      errorMessage: 'Password should match',
    }
  ])

  .onSuccess((event) => {
    document.getElementById('signup').submit();
  });
