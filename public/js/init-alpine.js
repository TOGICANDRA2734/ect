function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isConvertMenuOpen: false,
    toggleConvertMenu() {
      this.isConvertMenuOpen = !this.isConvertMenuOpen
    },
    closeConvertMenu() {
      this.isConvertMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },
    isPagesMenuOpen1: false,
    togglePagesMenu1() {
      this.isPagesMenuOpen1 = !this.isPagesMenuOpen1
    },
    isPagesMenuOpen2: false,
    togglePagesMenu2() {
      this.isPagesMenuOpen2 = !this.isPagesMenuOpen2
    },
    isPagesMenuOpen3: false,
    togglePagesMenu3() {
      this.isPagesMenuOpen3 = !this.isPagesMenuOpen3
    },
    // Modal 1 - Login
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeModal() {
      this.isModalOpen = false
      this.trapCleanup()
    },
    
    // Modal 2
    isModalOpen2: false,
    trapCleanup: null,
    selectedData: '',
    
    openModal2($data) {
      this.isModalOpen2 = true
      this.trapCleanup = focusTrap(document.querySelector('#modal2'))
      this.selectedData = $data  
    },
    closeModal2() {
      this.isModalOpen2 = false
      this.trapCleanup()
    },

    // Modal 3
    isModalOpen3: false,
    trapCleanup: null,
    openModal3() {
      this.isModalOpen3 = true
      this.trapCleanup = focusTrap(document.querySelector('#modal3'))
    },
    closeModal3() {
      this.isModalOpen3 = false
      this.trapCleanup()
    },
  }
}
