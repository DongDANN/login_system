console.log("validation.js loaded successfully");

const validation = new JustValidate('#reset');

validation
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
    document.getElementById('reset').submit();
  });