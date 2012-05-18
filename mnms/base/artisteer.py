from bs4 import BeautifulSoup


class ArtisteerPage(object):

    def __init__(self, page):
        self.soup = BeautifulSoup(page)
        self.output = BeautifulSoup('<html><head></head><body></body></html>')

        for js in self.get_js():
            new_tag = BeautifulSoup(str(js))
            self.output.head.append(new_tag.script)

        for js in self.get_css_link():
            new_tag = BeautifulSoup(str(js))
            self.output.head.append(new_tag.link)

        for js in self.get_css():
            new_tag = BeautifulSoup(str(js))
            self.output.head.append(new_tag.style)

    def get_css(self):
        return self.soup.find_all('style')

    def get_css_link(self):
        return self.soup.find_all('link')

    def get_js(self):
        return self.soup.find_all('script')

    def remove_vmenublock(self):
        for s in self.soup.select('.art-vmenublock'):
            s.extract()

    def remove_rss(self):
        for s in self.soup.select('.art-rss-tag-icon'):
            s.extract()

    def remove_footer_text(self):
        self.soup.select('.art-footer-text')[0].clear()

    def remove_main_content(self):
        o = self.soup.select('#preview-image')[0].parent.parent
        o.clear()
        return o

    def remove_block_content(self):
        self.soup.select('.art-blockcontent-body')[0].clear()

    def remove_art_page_footer(self):
        self.soup.select('.art-page-footer')[0].clear()
