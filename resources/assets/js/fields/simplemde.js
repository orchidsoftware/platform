let init = (id, placeholder) => {
  new SimpleMDE({
    element: document.getElementById(id),
    toolbar: [
      'bold',
      'italic',
      'heading',
      '|',
      'quote',
      'code',
      'unordered-list',
      'ordered-list',
      '|',
      'link',
      'image',
      'table',
      '|',
      'preview',
      'side-by-side',
      'fullscreen',
      '|',
      'horizontal-rule',
      'guide',
    ],
    placeholder: placeholder,
    spellChecker: false,
  });
};

export { init };
