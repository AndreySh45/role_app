<script setup>
import {DotsHorizontalIcon} from "@heroicons/vue/solid";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import CardListItemCreateForm from "@/Pages/Boards/CardListItemCreateForm";
import {ref, watch} from "vue";
import CardListItem from "@/Pages/Boards/CardListItem";
import Draggable from 'vuedraggable'
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
  list: Object
});

const listRef = ref();
const cards = ref(props.list.cards);

watch(() => props.list.cards, (newCards) => cards.value = newCards);

function onCardCreated() {
  listRef.value.scrollTop = listRef.value.scrollHeight;
}

function onChange(e) {
  let item = e.added || e.moved;

  if (!item) return;

  let index = item.newIndex;
  let prevCard = cards.value[index - 1];
  let nextCard = cards.value[index + 1];
  let card = cards.value[index];

  let position = card.position;

  if (prevCard && nextCard) {
    position = (prevCard.position + nextCard.position) / 2;
  } else if (prevCard) {
    position = prevCard.position + (prevCard.position / 2);
  } else if (nextCard) {
    position = nextCard.position / 2;
  }

  Inertia.put(route('cards.move', {card: card.id}), {
    position: position,
    cardListId: props.list.id
  });
  console.log(e);
}

</script>

<template>
<div>
  <div class="flex items-center justify-between px-3 py-2">
    <h3 class="text-sm font-semibold text-gray-700">
      {{ list.name }}
    </h3>
    <Menu as="div" class="relative z-10">
      <MenuButton class="hover:bg-gray-300 w-8 h-8 rounded-md grid place-content-center">
        <DotsHorizontalIcon class="w-5 h-5"/>
      </MenuButton>

      <transition
        enter-active-class="transition transform duration-100 ease-out"
        enter-from-class="opacity-0 scale-90"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition transform duration-100 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-90"
      >
        <MenuItems class="origin-top-left mt-2 focus:outline-none absolute left-0 bg-white overflow-hidden rounded-md shadow-lg border w-40">
          <MenuItem v-slot="{active}">
            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-gray-700">
            Add card</a>
          </MenuItem>
          <MenuItem v-slot="{active}">
            <a href="#" :class="{'bg-gray-100': active}" class="block px-4 py-2 text-sm text-red-600">
            Delete list</a>
          </MenuItem>
        </MenuItems>
      </transition>
    </Menu>
  </div>
  <div class="flex overflow-hidden flex-col pb-3">
    <div ref="listRef" class="px-3 flex-1 overflow-y-auto">
      <Draggable
          v-model="cards"
          class="space-y-3"
          drag-class="drag"
          ghost-class="ghost"
          group="cards"
          item-key="id"
          tag="ul"
          @change="onChange"
          >
          <template #item="{element}">
            <CardListItem :card="element" />
          </template>
      </Draggable>
    </div>

    <div class="px-3 mt-3">
      <CardListItemCreateForm
          :list="list"
          @created="onCardCreated()"
      />
    </div>
  </div>
</div>
</template>
