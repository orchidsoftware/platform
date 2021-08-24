import Quill from "quill";

let currentQuill;
const BlockEmbed = Quill.import("blots/block/embed");
const Link = Quill.import("formats/link");

class VideoResponsive extends BlockEmbed {
  static blotName = "video";
  static tagName = "div";
  static wrapVideo = false;

  static create(value) {
    let node;
    this.wrapVideo = currentQuill.dataset.wrapVideo == '1';

    if(this.wrapVideo) {
      node = this.setWrapVideo(value);
    } else {
      this.tagName = 'iframe';
      node = super.create(value);
      this.setIframe(node, value);
    }

    return node;
  }

  static setWrapVideo(value) {
    const node = super.create(value);
    node.classList.add("ql-video-wrapper");

    const innerChild = document.createElement("div");
    innerChild.classList.add("ql-video-inner");
    node.appendChild(innerChild);

    const child = document.createElement("iframe");
    this.setIframe(child, value)
    innerChild.appendChild(child);

    return node;
  }

  static setIframe(iFrame, url) {
    iFrame.setAttribute('frameborder', '0');
    iFrame.setAttribute('allowfullscreen', true);
    iFrame.setAttribute('src', this.sanitize(url));
    iFrame.classList.add('ql-video');
  }

  static sanitize(url) {
    return Link.sanitize(url);
  }

  static value(domNode) {
    const iframe = this.wrapVideo ? domNode.querySelector('iframe') : domNode;
    return iframe.getAttribute('src');
  }
}

export default (quillElement) => {

  quillElement.getElementsByClassName('ql-editor')[0].addEventListener('focus', () => {
    currentQuill = quillElement;
  });

  return VideoResponsive;
}
