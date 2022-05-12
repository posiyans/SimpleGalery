import { computed, ref } from 'vue'
import { next, prev, closeShowMedia } from 'src/modules/Media/use/showAction'
const isFirefox = function () {
  return window.navigator.userAgent.match(/firefox/i)
}

const mousewheelEventName = isFirefox() ? 'DOMMouseScroll' : 'mousewheel'

const EVENT_CODE = {
  tab: 'Tab',
  enter: 'Enter',
  space: 'Space',
  left: 'ArrowLeft', // 37
  up: 'ArrowUp', // 38
  right: 'ArrowRight', // 39
  down: 'ArrowDown', // 40
  esc: 'Escape',
  delete: 'Delete',
  backspace: 'Backspace',
  numpadEnter: 'NumpadEnter',
  pageUp: 'PageUp',
  pageDown: 'PageDown',
  home: 'Home',
  end: 'End'
}
const Mode = {
  CONTAIN: {
    name: 'contain',
    icon: 'fullscreen'
  },
  ORIGINAL: {
    name: 'original',
    icon: 'settings_overscan'
  }
}

const transform = ref({
  scale: 1,
  deg: 0,
  offsetX: 0,
  offsetY: 0,
  enableTransition: false
})
const loading = ref(false)
const mode = ref(Mode.CONTAIN)

const imgStyle = computed(() => {
  const { scale, deg, offsetX, offsetY, enableTransition } = transform.value
  const style = {
    transform: `scale(${scale}) rotate(${deg}deg)`,
    transition: enableTransition ? 'transform .3s' : '',
    marginLeft: `${offsetX}px`,
    marginTop: `${offsetY}px`
  }
  if (mode.value.name === Mode.CONTAIN.name) {
    style.maxWidth = style.maxHeight = '100%'
  }
  return style
})

function toggleMode() {
  if (loading.value) return
  const modeNames = Object.keys(Mode)
  const modeValues = Object.values(Mode)
  const currentMode = mode.value.name
  const index = modeValues.findIndex((i) => i.name === currentMode)
  const nextIndex = (index + 1) % modeNames.length
  mode.value = Mode[modeNames[nextIndex]]
  reset()
}

function reset() {
  transform.value = {
    scale: 1,
    deg: 0,
    offsetX: 0,
    offsetY: 0,
    enableTransition: false
  }
}
const hide = () => {
  closeShowMedia()
}

function handleActions(action) {
  if (loading.value) return
  const { zoomRate, rotateDeg, enableTransition } = {
    zoomRate: 0.2,
    rotateDeg: 90,
    enableTransition: true
  }
  switch (action) {
    case 'zoomOut':
      if (transform.value.scale > 0.2) {
        transform.value.scale = parseFloat((transform.value.scale - zoomRate).toFixed(3)
        )
      }
      break
    case 'zoomIn':
      transform.value.scale = parseFloat((transform.value.scale + zoomRate).toFixed(3)
      )
      break
    case 'clockwise':
      transform.value.deg += rotateDeg
      break
    case 'anticlockwise':
      transform.value.deg -= rotateDeg
      break
  }
  transform.value.enableTransition = enableTransition
}

function registerEventListener() {
  const keydownHandler = (e) => {
    switch (e.code) {
      // ESC
      case EVENT_CODE.esc:
        hide()
        break
      // SPACE
      case EVENT_CODE.space:
        toggleMode()
        break
      // LEFT_ARROW
      case EVENT_CODE.left:
        prev()
        break
      // UP_ARROW
      case EVENT_CODE.up:
        handleActions('zoomIn')
        break
      // RIGHT_ARROW
      case EVENT_CODE.right:
        next()
        break
      // DOWN_ARROW
      case EVENT_CODE.down:
        handleActions('zoomOut')
        break
    }
  }
  const mousewheelHandler = (e) => {
    const delta = e.wheelDelta ? e.wheelDelta : -e.detail
    if (delta > 0) {
      handleActions('zoomIn', {
        zoomRate: 0.015,
        enableTransition: false
      })
    } else {
      handleActions('zoomOut', {
        zoomRate: 0.015,
        enableTransition: false
      })
    }
  }

  document.addEventListener('keydown', keydownHandler)
  document.addEventListener(mousewheelEventName, mousewheelHandler)
}
// function unregisterEventListener() {
//   document.removeEventListener('keydown', keydownHandler)
//   document.addEventListener(mousewheelEventName, mousewheelHandler)
// }

function handleMouseDown(e) {
  const pointerEventToXY = function(e) {
    const out = { x: 0, y: 0 }
    if (e.type === 'touchstart' || e.type === 'touchmove' || e.type === 'touchend' || e.type === 'touchcancel') {
      const touch = e.changedTouches[0]
      out.x = touch.pageX * 2
      out.y = touch.pageY * 2
    } else if (e.type === 'mousedown' || e.type === 'mouseup' || e.type === 'mousemove' || e.type === 'mouseover' || e.type === 'mouseout' || e.type === 'mouseenter' || e.type === 'mouseleave') {
      out.x = e.pageX
      out.y = e.pageY
    }
    return out
  }

  // if (loading.value || e.button !== 0) return
  if (loading.value) return
  const { offsetX, offsetY } = transform.value
  const xy = pointerEventToXY(e)
  const startX = xy.x
  const startY = xy.y
  const dragHandler = (ev) => {
    const xy = pointerEventToXY(ev)
    console.log(xy)
    transform.value = {
      ...transform.value,
      offsetX: offsetX + xy.x - startX,
      offsetY: offsetY + xy.y - startY
    }
  }
  if (e.type === 'touchstart') {
    document.addEventListener('touchmove', dragHandler)
    document.addEventListener('touchend', (evt) => {
      document.removeEventListener('touchmove', dragHandler)
      document.removeEventListener('touchend', this)
    })
  } else {
    document.addEventListener('mousemove', dragHandler)
    document.addEventListener('mouseup', (evt) => {
      document.removeEventListener('mousemove', dragHandler)
      document.removeEventListener('mouseup', this)
    })
  }
  e.preventDefault()
}

export {
  handleMouseDown,
  reset,
  registerEventListener,
  toggleMode,
  mode,
  handleActions,
  imgStyle,
  loading
}
