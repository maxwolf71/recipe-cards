import axios from "axios";
import storage from '../plugins/storage'

const userService = {
  jwtBaseURI: process.env.VUE_APP_WORDPRESS_API_URL + "/jwt-auth/v1",
  cookingBaseURI: process.env.VUE_APP_WORDPRESS_API_URL + "/cooking/v1",

  login: async (login, password) => {
    let response = await axios.post(userService.jwtBaseURI + "/token", 
    {
      username: login,
      password: password,
    }).catch(() => {
        return false
    })

    return response.data;
  },

  logout: () => {
    storage.unset('userData')
  },

  isLoggedIn: async () => {
    // retrieve token from localStorage
    const userData = storage.get('userData');
    // is userData empty ?
    if(userData != null) {
      const token = userData.token;
      if(token) {
        // api call to validate token
        const options = {
          headers: {
            Authorization: 'Bearer' + token
          }
        }
        const response = await axios.post(
          userService.jwtBaseURI + '/token/validate',
          null,
          options
        ).catch(() => {
          // invalid token
          return false
        })
        return response.data
      }
    }
    return false
  },
  register: async (username, email,password) => {
    const response = await axios.post(
      userService.cookingBaseURI + '/register',
      {
        username: username,
        email: email,
        password: password
      } 
    ).catch((error) => {
      console.log(error);
      return false
  })
    return response.data;
  }
};

export default userService;
