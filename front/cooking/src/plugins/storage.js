const storage = {
  set(variableName, value) {
    const json = JSON.stringify(value);

    window.localStorage.setItem(variableName, json);
  },
  get(variableName) {
    const json = window.localStorage.getItem(variableName);
    const value = JSON.parse(json);

    return value;
  },
  unset(variableName) {
    window.localStorage.removeItem(variableName)
  }
};

export default storage;
