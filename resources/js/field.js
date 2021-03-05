import NestedGalleryField from './components/NestedGalleryField'
import VueFileAgent from 'vue-file-agent';

Nova.booting((Vue, router, store) => {
  

  // const SortableList = {
  //   mixins: [ContainerMixin],
  //   template: `
  //   <ul class="list">
  //     <slot />
  //   </ul>
  // `,
  // };

  // const SortableItem = {
  //   mixins: [ElementMixin],
  //   props: ['item'],
  //   template: `
  //   <li class="list-item">{{item}}</li>
  // `,
  // };

  // // Vue.component('vfa-sortable-list', SlickList);
  // // Vue.component('vfa-sortable-item', SlickItem);
  // Vue.component('vfa-sortable-list', SortableList);
  // Vue.component('vfa-sortable-item', SortableItem);
  
  Vue.use(VueFileAgent);
  Vue.component('form-nested-gallery', NestedGalleryField)
  
  
})
